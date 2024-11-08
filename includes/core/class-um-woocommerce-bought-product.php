<?php
/**
 * Inits the extension.
 *
 * @package um_ext\um_woocommerce_bought_product\core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class UM_Woocommerce_Bought_Product
 */
class UM_Woocommerce_Bought_Product {


	/**
	 * An instance of the class.
	 *
	 * @var UM_Woocommerce_Bought_Product
	 */
	private static $instance;


	/**
	 * Creates an instance of the class.
	 *
	 * @return UM_Woocommerce_Bought_Product
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


	/**
	 * UM_Woocommerce_Bought_Product constructor.
	 */
	public function __construct() {
		$this->dashboard();
		$this->fields();
		$this->member_directory();
		$this->order();
	}


	/**
	 * Get instance of the class that extends Ultimate Member dashboard.
	 *
	 * @return um_ext\um_woocommerce_bought_product\admin\Dashboard()
	 */
	public function dashboard() {
		if ( empty( UM()->classes['um_woocommerce_bought_product_dashboard'] ) ) {
			UM()->classes['um_woocommerce_bought_product_dashboard'] = new um_ext\um_woocommerce_bought_product\admin\Dashboard();
		}
		return UM()->classes['um_woocommerce_bought_product_dashboard'];
	}


	/**
	 * Extend fields.
	 *
	 * @return um_ext\um_woocommerce_bought_product\core\Fields()
	 */
	public function fields() {
		if ( empty( UM()->classes['um_woocommerce_bought_product_fields'] ) ) {
			UM()->classes['um_woocommerce_bought_product_fields'] = new um_ext\um_woocommerce_bought_product\core\Fields();
		}
		return UM()->classes['um_woocommerce_bought_product_fields'];
	}


	/**
	 * Extend member directory.
	 *
	 * @return um_ext\um_woocommerce_bought_product\core\Member_Directory()
	 */
	public function member_directory() {
		if ( empty( UM()->classes['um_woocommerce_bought_product_member_directory'] ) ) {
			UM()->classes['um_woocommerce_bought_product_member_directory'] = new um_ext\um_woocommerce_bought_product\core\Member_Directory();
		}
		return UM()->classes['um_woocommerce_bought_product_member_directory'];
	}


	/**
	 * Extend order actions.
	 *
	 * @return um_ext\um_woocommerce_bought_product\core\Order()
	 */
	public function order() {
		if ( empty( UM()->classes['um_woocommerce_bought_product_order'] ) ) {
			UM()->classes['um_woocommerce_bought_product_order'] = new um_ext\um_woocommerce_bought_product\core\Order();
		}
		return UM()->classes['um_woocommerce_bought_product_order'];
	}

}
