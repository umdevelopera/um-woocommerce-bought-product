<?php
defined( 'ABSPATH' ) || exit;

/**
 * Init the extension.
 *
 * @package um_ext\um_woocommerce_tools
 */
class UM_Woocommerce_Tools {

	/**
	 * An instance of the class.
	 *
	 * @var UM_Woocommerce_Tools
	 */
	private static $instance;

	/**
	 * Creates an instance of the class.
	 *
	 * @return UM_Woocommerce_Tools
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->core();
		if ( UM()->is_request( 'admin' ) ) {
			$this->admin();
		} elseif ( UM()->is_request( 'frontend' ) ) {
		}
	}

	/**
	 * Admin features.
	 *
	 * @return um_ext\um_woocommerce_tools\admin\Init
	 */
	public function admin() {
		if ( empty( UM()->classes['um_woocommerce_tools_admin'] ) ) {
			UM()->classes['um_woocommerce_tools_admin'] = new um_ext\um_woocommerce_tools\admin\Init();
		}
		return UM()->classes['um_woocommerce_tools_admin'];
	}

	/**
	 * Core features.
	 *
	 * @return um_ext\um_woocommerce_tools\core\Init
	 */
	public function core() {
		if ( empty( UM()->classes['um_woocommerce_tools_core'] ) ) {
			UM()->classes['um_woocommerce_tools_core'] = new um_ext\um_woocommerce_tools\core\Init();
		}
		return UM()->classes['um_woocommerce_tools_core'];
	}

}
