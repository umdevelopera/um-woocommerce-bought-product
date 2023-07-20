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

		// Ignore the Privacy option for the "Bought products" filter.
		add_action( 'um_before_directory_form_is_loaded', array( $this, 'can_view_field_on' ) );
		add_action( 'um_member_directory_before_query', array( $this, 'can_view_field_on' ) );
		add_action( 'um_members_directory_head', array( $this, 'can_view_field_off' ) );

		add_filter( 'um_members_directory_filter_fields', array( $this, 'extend_filter_fields' ), 10, 1 );
		add_filter( 'um_members_directory_filter_types', array( $this, 'extend_filter_types' ), 10, 1 );
	}


	/**
	 * Turn ON the "Bought products" filter.
	 *
	 * @param array $args Form arguments.
	 */
	public function can_view_field_on( $args ) {
		$can_view_field = apply_filters( 'um_woocommerce_bought_product_can_view_field', false );
		if ( $can_view_field ) {
			add_filter( 'um_can_view_field', array( $this, 'can_view_field' ), 10, 2 );
		}
	}

	/**
	 * Turn OFF the "Bought products" filter.
	 *
	 * @param array $args Form arguments.
	 */
	public function can_view_field_off( $args ) {
		remove_filter( 'um_can_view_field', array( $this, 'can_view_field' ), 10 );
	}


	/**
	 * Show the "Bought products" filter regardless of the field privacy and visibility.
	 *
	 * @param  boolean $can_view Can view field.
	 * @param  array   $data     Form arguments.
	 * @return boolean
	 */
	public function can_view_field( $can_view, $data ) {
		if ( is_array( $data ) && array_key_exists( 'metakey', $data ) && 'woo_bought_products' === $data['metakey'] ) {
			$can_view = true;
		}
		return $can_view;
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
