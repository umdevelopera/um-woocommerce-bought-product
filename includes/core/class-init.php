<?php
namespace um_ext\um_woocommerce_tools\core;

defined( 'ABSPATH' ) || exit;

/**
 * Core features.
 *
 * Get an instance this way: UM()->Woocommerce_Tools()->core()
 *
 * @package um_ext\um_woocommerce_tools\core
 */
class Init {

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->fields();
		$this->member_directory();
		$this->order();

		if ( is_plugin_active( 'woocommerce-subscriptions/woocommerce-subscriptions.php' ) ) {
			$this->subscription();
		}
	}

	/**
	 * Extend fields.
	 *
	 * @return Fields
	 */
	public function fields() {
		if ( empty( UM()->classes['um_woocommerce_tools_fields'] ) ) {
			UM()->classes['um_woocommerce_tools_fields'] = new Fields();
		}
		return UM()->classes['um_woocommerce_tools_fields'];
	}


	/**
	 * Extend member directory.
	 *
	 * @return Member_Directory
	 */
	public function member_directory() {
		if ( empty( UM()->classes['um_woocommerce_tools_member_directory'] ) ) {
			UM()->classes['um_woocommerce_tools_member_directory'] = new Member_Directory();
		}
		return UM()->classes['um_woocommerce_tools_member_directory'];
	}


	/**
	 * Extend order actions.
	 *
	 * @return Order
	 */
	public function order() {
		if ( empty( UM()->classes['um_woocommerce_tools_order'] ) ) {
			UM()->classes['um_woocommerce_tools_order'] = new Order();
		}
		return UM()->classes['um_woocommerce_tools_order'];
	}


	/**
	 * Extend subscription actions.
	 *
	 * @return Subscription
	 */
	public function subscription() {
		if ( empty( UM()->classes['um_woocommerce_tools_subscription'] ) ) {
			UM()->classes['um_woocommerce_tools_subscription'] = new Subscription();
		}
		return UM()->classes['um_woocommerce_tools_subscription'];
	}
}
