<?php
namespace um_ext\um_woocommerce_tools\admin;

defined( 'ABSPATH' ) || exit;

/**
 * Extend Ultimate Member settings.
 *
 * Get an instance this way: UM()->Woocommerce_Tools()->admin()->settings()
 *
 * @package um_ext\um_woocommerce_tools\admin
 * @since 1.3.0
 */
class Settings {

	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_filter( 'um_settings_structure', array( $this, 'woocommerce_settings' ), 12 );
	}

	/**
	 * Extend WooCommerce extension settings.
	 *
	 * @param array $settings Settings structure.
	 * @return array
	 */
	public function woocommerce_settings( $settings ) {
		if ( isset( $settings['extensions']['sections']['woocommerce'] ) && is_plugin_active( 'woocommerce-subscriptions/woocommerce-subscriptions.php' ) ) {
			$settings['extensions']['sections']['woocommerce']['fields'][] = array(
				'id'        => 'woo_subscription_remove_roles',
				'type'      => 'select',
				'size'      => 'small',
				'label'     => __( 'Remove other roles when assign a role on subscription status change or switching a subscription.', 'um-woocommerce-tools' ),
				'description'   => __( 'Keep only the assigned role if Yes. Keep all roles but make the assigned role first if No.', 'um-woocommerce-tools' ),
				'options'   => array(
					0 => __( 'No', 'um-woocommerce-tools' ),
					1 => __( 'Yes', 'um-woocommerce-tools' )
				),
			);
		}

		return $settings;
	}

}
