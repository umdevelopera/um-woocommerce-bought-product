<?php
/**
 * Extend member directory filters.
 *
 * @package um_ext\um_woocommerce_bought_product\core
 */

namespace um_ext\um_woocommerce_bought_product\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Extend member directory filters.
 *
 * @package um_ext\um_woocommerce_bought_product\core
 */
class Member_Directory {


	/**
	 * Class Member_Directory constructor.
	 */
	public function __construct() {
		add_filter( 'um_members_directory_filter_fields', array( $this, 'extend_filter_fields' ), 10, 1 );
		add_filter( 'um_members_directory_filter_types', array( $this, 'extend_filter_types' ), 10, 1 );
	}


	/**
	 * Add the "Bought products" field to the member directory filters.
	 *
	 * @param  array $filter_fields Filters.
	 * @return array
	 */
	public function extend_filter_fields( $filter_fields ) {
		$filter_fields['woo_bought_products'] = __( 'Bought products', 'um-woocommerce-bought-product' );
		return $filter_fields;
	}


	/**
	 * Set type for the "Bought products" filter.
	 *
	 * @param array $filter_types Filter types.
	 * @return string
	 */
	public function extend_filter_types( $filter_types ) {
		$filter_types['woo_bought_products'] = 'select';
		return $filter_types;
	}

}
