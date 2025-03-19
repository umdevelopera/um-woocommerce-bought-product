<?php
namespace um_ext\um_woocommerce_tools\admin;

defined( 'ABSPATH' ) || exit;

/**
 * Admin features.
 *
 * Get an instance this way: UM()->Woocommerce_Tools()->admin()
 *
 * @package um_ext\um_woocommerce_tools\admin
 */
class Init {


	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->dashboard();
		$this->settings();
	}

	/**
	 * Extend Ultimate Member dashboard.
	 *
	 * @return Dashboard
	 */
	public function dashboard() {
		if ( empty( UM()->classes['um_woocommerce_tools_dashboard'] ) ) {
			UM()->classes['um_woocommerce_tools_dashboard'] = new Dashboard();
		}
		return UM()->classes['um_woocommerce_tools_dashboard'];
	}

	/**
	 * Extend Ultimate Member settings.
	 *
	 * @return Settings
	 */
	public function settings() {
		if ( empty( UM()->classes['um_woocommerce_tools_settings'] ) ) {
			UM()->classes['um_woocommerce_tools_settings'] = new Settings();
		}
		return UM()->classes['um_woocommerce_tools_settings'];
	}
}
