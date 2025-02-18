<?php
/**
	Plugin Name: Ultimate Member - WooCommerce (bought products)
	Plugin URI:  https://github.com/umdevelopera/um-woocommerce-bought-product
	Description: Adds the "Bought products" field and filter.
	Version:     1.1.0
	Author:      umdevelopera
	Author URI:  https://github.com/umdevelopera
	Text Domain: um-woocommerce-bought-product
	Domain Path: /languages
	UM version:  2.6.7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once ABSPATH . 'wp-admin/includes/plugin.php';

$plugin_data = get_plugin_data( __FILE__ );

define( 'um_woocommerce_bought_product_url', plugin_dir_url( __FILE__ ) );
define( 'um_woocommerce_bought_product_path', plugin_dir_path( __FILE__ ) );
define( 'um_woocommerce_bought_product_plugin', plugin_basename( __FILE__ ) );
define( 'um_woocommerce_bought_product_extension', $plugin_data['Name'] );
define( 'um_woocommerce_bought_product_version', $plugin_data['Version'] );
define( 'um_woocommerce_bought_product_textdomain', 'um-woocommerce-bought-product' );
define( 'um_woocommerce_bought_product_requires', '2.6.7' );

// Activation script.
if ( ! function_exists( 'um_woocommerce_bought_product_activation_hook' ) ) {
	function um_woocommerce_bought_product_activation_hook() {
		$version = get_option( 'um_woocommerce_bought_product_version' );
		if ( ! $version ) {
			update_option( 'um_woocommerce_bought_product_last_version_upgrade', um_woocommerce_bought_product_version );
		}
		if ( um_woocommerce_bought_product_version !== $version ) {
			update_option( 'um_woocommerce_bought_product_version', um_woocommerce_bought_product_version );
		}
		if ( ! class_exists( 'um_ext\um_woocommerce_bought_product\core\Setup' ) ) {
			require_once 'includes/core/class-setup.php';
		}
		$setup = new um_ext\um_woocommerce_bought_product\core\Setup();
		$setup->run_setup();
	}
}
register_activation_hook( __FILE__, 'um_woocommerce_bought_product_activation_hook' );

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

			function um_woocommerce_bought_product_init() {
				if ( function_exists( 'UM' ) ) {
					UM()->set_class( 'Woocommerce_Bought_Product', true );
				}
			}
			add_action( 'plugins_loaded', 'um_woocommerce_bought_product_init', -10, 1 );
		}
	}
}
add_action( 'plugins_loaded', 'um_woocommerce_bought_product_check_dependencies', -20 );

// Loads a plugin's translated strings.
if ( ! function_exists( 'um_woocommerce_bought_product_plugins_loaded' ) ) {
	function um_woocommerce_bought_product_plugins_loaded() {
		$locale = ( get_locale() !== '' ) ? get_locale() : 'en_US';
		load_textdomain( um_woocommerce_bought_product_textdomain, WP_LANG_DIR . '/plugins/' . um_woocommerce_bought_product_textdomain . '-' . $locale . '.mo' );
		load_plugin_textdomain( um_woocommerce_bought_product_textdomain, false, dirname( um_woocommerce_bought_product_plugin ) . '/languages/' );
	}
}
add_action( 'plugins_loaded', 'um_woocommerce_bought_product_plugins_loaded', 0 );
