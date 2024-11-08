<?php
/**
 * Plugin Name: Ultimate Member - Bought products
 * Plugin URI:  https://github.com/umdevelopera/um-woocommerce-bought-product
 * Description: Adds the "Bought products" field and filter based on WooCommerce orders
 * Author:      umdevelopera
 * Author URI:  https://github.com/umdevelopera
 * Text Domain: um-woocommerce-bought-product
 * Domain Path: /languages
 *
 * Requires at least: 6.5
 * Requires PHP: 7.4
 * UM version: 2.9.0
 * Version: 1.2.1
 *
 * @package um_ext\um_woocommerce_bought_product
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once ABSPATH . 'wp-admin/includes/plugin.php';

$plugin_data = get_plugin_data( __FILE__, true, false );

define( 'um_woocommerce_bought_product_url', plugin_dir_url( __FILE__ ) );
define( 'um_woocommerce_bought_product_path', plugin_dir_path( __FILE__ ) );
define( 'um_woocommerce_bought_product_plugin', plugin_basename( __FILE__ ) );
define( 'um_woocommerce_bought_product_extension', $plugin_data['Name'] );
define( 'um_woocommerce_bought_product_version', $plugin_data['Version'] );
define( 'um_woocommerce_bought_product_textdomain', 'um-woocommerce-bought-product' );


// Activation script.
if ( ! function_exists( 'um_woocommerce_bought_product_activation_hook' ) ) {
	function um_woocommerce_bought_product_activation_hook() {
		if ( function_exists( 'UM' ) && UM()->dependencies()->woocommerce_active_check() ) {
			require_once 'includes/core/class-setup.php';
			if ( class_exists( 'um_ext\um_woocommerce_bought_product\core\Setup' ) ) {
				$setup = new um_ext\um_woocommerce_bought_product\core\Setup();
				$setup->run();
			}
		}
	}
}
register_activation_hook( um_woocommerce_bought_product_plugin, 'um_woocommerce_bought_product_activation_hook' );


// Check dependencies.
if ( ! function_exists( 'um_woocommerce_bought_product_check_dependencies' ) ) {
	function um_woocommerce_bought_product_check_dependencies() {
		if ( ! defined( 'um_path' ) || ! function_exists( 'UM' ) || ! UM()->dependencies()->ultimatemember_active_check() ) {
			// Ultimate Member is not active.
			add_action(
				'admin_notices',
				function () {
					// translators: %s - plugin name.
					echo '<div class="error"><p>' . wp_kses_post( sprintf( __( 'The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>', 'um-woocommerce-bought-product' ), um_woocommerce_bought_product_extension ) ) . '</p></div>';
				}
			);
		} elseif ( ! UM()->dependencies()->woocommerce_active_check() ) {
			// WooCommerce is not active.
			add_action(
				'admin_notices',
				function () {
					// translators: %s - plugin name.
					echo '<div class="error"><p>' . wp_kses_post( sprintf( __( 'The <strong>%s</strong> extension requires WooCommerce plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/woocommerce/">here</a>', 'um-woocommerce-bought-product' ), um_woocommerce_bought_product_extension ) ) . '</p></div>';
				}
			);
		} else {
			require_once 'includes/core/class-um-woocommerce-bought-product.php';
			UM()->set_class( 'Woocommerce_Bought_Product', true );
		}
	}
}
add_action( 'plugins_loaded', 'um_woocommerce_bought_product_check_dependencies', 2 );


// Declaring extension compatibility.
if ( ! function_exists( 'um_woocommerce_bought_product_hpos_declare_compatibility' ) ) {
	function um_woocommerce_bought_product_hpos_declare_compatibility() {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
		}
	}
	add_action( 'before_woocommerce_init', 'um_woocommerce_bought_product_hpos_declare_compatibility' );
}
