<?php
namespace um_ext\um_woocommerce_tools\core;

defined( 'ABSPATH' ) || exit;

/**
 * Extend subscription actions.
 *
 * Get an instance this way: UM()->Woocommerce_Tools()->core()->subscription()
 *
 * @package um_ext\um_woocommerce_tools\core
 * @since 1.3.0
 */
class Subscription {

	public $assigned_role = '';

	/**
	 * Class constructor.
	 */
	public function __construct() {

		// Role detection.
		add_action( 'woocommerce_subscription_status_changed', array( $this, 'enable_new_role_detection' ), 8 );
		add_action( 'woocommerce_subscription_status_changed', array( $this, 'disable_new_role_detection' ), 12 );
		add_action( 'woocommerce_subscriptions_switch_completed', array( $this, 'enable_new_role_detection' ), 8 );
		add_action( 'woocommerce_subscriptions_switch_completed', array( $this, 'disable_new_role_detection' ), 12 );

		// Maybe remove roles.
		add_action( 'woocommerce_subscription_status_changed', array( $this, 'remove_roles_on_status_changed' ), 20, 4 );
		add_action( 'woocommerce_subscriptions_switch_completed', array( $this, 'remove_roles_on_switch' ), 20, 1 );
	}

	/**
	 * Enable method that saves assigned_role.
	 * hook     - woocommerce_subscription_status_changed
	 * priority - 8
	 */
	public function enable_new_role_detection(){
		$this->assigned_role = '';
		add_action( 'um_after_member_role_upgrade', array( $this, 'new_role_detection' ), 10, 3 );
	}

	/**
	 * Disable method that saves assigned_role.
	 * hook     - woocommerce_subscription_status_changed
	 * priority - 12
	 */
	public function disable_new_role_detection(){
		remove_action( 'um_after_member_role_upgrade', array( $this, 'new_role_detection' ), 10, 3 );
	}

	/**
	 * Make a role the first.
	 *
	 * @param  \WP_User $user User.
	 * @param  string   $role Role.
	 * @return bool
	 */
	public function make_user_role_primary( $user, $role ) {
		if ( empty( $role ) ) {
			return;
		}
		if ( ! in_array( $role, $user->roles, true ) ) {
			return;
		}

		$role_caps = $user->caps[ $role ];
		$user_caps = array_merge(
			array(
				$role => $role_caps,
			),
			$user->caps
		);
		update_user_meta( $user->ID, $user->cap_key, $user_caps );
		$user->get_role_caps();
	}

	/**
	 * Save assigned_role.
	 *
	 * Hook: um_after_member_role_upgrade
	 *
	 * @param array $new_roles New roles.
	 * @param array $old_roles Old roles.
	 * @param int   $user_id   User ID.
	 */
	public function new_role_detection( $new_roles, $old_roles, $user_id ) {
		$assigned_roles = array_diff( $new_roles, $old_roles );
		if ( $assigned_roles ) {
			$this->assigned_role = current( $assigned_roles );
		}
	}

	/**
	 * Maybe remove old roles on subscription status changes.
	 *
	 * Hook: woocommerce_subscription_status_changed - 20
	 *
	 * @param iny              $subscription_id Subscription ID.
	 * @param string           $old_status      Old subscription status.
	 * @param string           $new_status      New subscription status.
	 * @param \WC_Subscription $subscription    Subscription object.
	 * @return bool
	 */
	public function remove_roles_on_status_changed( $subscription_id, $old_status, $new_status, $subscription ) {
		$user  = $subscription->get_user();
		$roles = $user->roles;

		if ( 2 > count( $roles ) ) {
			return;
		}

		$user_id = $subscription->get_user_id();
		if ( empty( $this->assigned_role ) ) {
			foreach ( $subscription->get_items() as $item ) {
				$product_id    = $item['product_id'];
				$assigned_role = get_user_meta( $user_id, '_um_woo_subscription_' . $subscription_id . '_product_' . $product_id . '_' . $new_status . '_role', true );
				if ( ! empty( $assigned_role ) && in_array( $assigned_role, $roles ) ) {
					$this->assigned_role = $assigned_role;
					break;
				}
			}
		}

		if ( ! empty( $this->assigned_role ) ) {
			if ( UM()->options()->get( 'woo_subscription_remove_roles' ) ) {
				$user->set_role( $this->assigned_role );
			} else {
				$this->make_user_role_primary( $user, $this->assigned_role );
			}

			// forcefully flush the cache.
			UM()->user()->remove_cache( $user_id );
		}
	}

	/**
	 * Maybe remove old roles on subscription switches.
	 *
	 * Hook: woocommerce_subscriptions_switch_completed - 20
	 *
	 * @param \WC_Order $order Order.
	 */
	public function remove_roles_on_switch( $order ) {
		$user  = $order->get_user();
		$roles = $user->roles;

		if ( 2 > count( $roles ) ) {
			return;
		}

		$user_id = $order->get_user_id();
		if ( ! empty( $this->assigned_role ) ) {
			if ( UM()->options()->get( 'woo_subscription_remove_roles' ) ) {
				$user->set_role( $this->assigned_role );
			} else {
				$this->make_user_role_primary( $user, $this->assigned_role );
			}

			// forcefully flush the cache.
			UM()->user()->remove_cache( $user_id );
		}
	}
}
