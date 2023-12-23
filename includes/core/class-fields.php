<?php
/**
 * Extend predefined fields.
 *
 * @package um_ext\um_woocommerce_bought_product\core
 */

namespace um_ext\um_woocommerce_bought_product\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Extend predefined fields.
 *
 * @package um_ext\um_woocommerce_bought_product\core
 */
class Fields {

	/**
	 * The "Bought products" field options.
	 *
	 * @var array
	 */
	private $options;


	/**
	 * Class Fields constructor.
	 */
	public function __construct() {
		// Add field.
		add_filter( 'um_predefined_fields_hook', array( $this, 'extend_predefined_fields' ), 101, 1 );

		// Filter options.
		add_filter( 'um_multiselect_options_woo_bought_products', array( $this, 'get_options' ), 10, 1 );
		add_filter( 'um_get_field__woo_bought_products', array( $this, 'filter_field_data' ), 10, 1 );

		// Use keys in options.
		add_filter( 'um_select_options_pair', array( $this, 'filter_use_keyword' ), 10, 2 );
	}


	/**
	 * Add the "Bought products" field to the predefined fields array.
	 *
	 * Hook: um_predefined_fields_hook
	 *
	 * @see \um\core\Builtin::set_predefined_fields()
	 *
	 * @param  array $fields Predefined fields.
	 *
	 * @return array
	 */
	public function extend_predefined_fields( $fields ) {

		if (
			isset( $_POST['nonce'] )
			&& isset( $_POST['action'] )
			&& isset( $_POST['act_id'] )
			&& isset( $_POST['form_mode'] )
			&& wp_verify_nonce( sanitize_key( wp_unslash( $_POST['nonce'] ) ), 'um-admin-nonce' )
			&& 'um_dynamic_modal_content' === wp_unslash( sanitize_key( $_POST['action'] ) )
			&& 'um_admin_show_fields' === wp_unslash( sanitize_key( $_POST['act_id'] ) )
			&& 'profile' !== wp_unslash( sanitize_key( $_POST['form_mode'] ) )
		) {
			// This field is specific tor the profile form and can be added to the registration form.
			return $fields;
		}

		$fields['woo_bought_products'] = array(
			'type'       => 'multiselect',
			'title'      => __( 'Bought products', 'um-woocommerce-bought-product' ),
			'label'      => __( 'Bought products', 'um-woocommerce-bought-product' ),
			'metakey'    => 'woo_bought_products',
			'options'    => $this->get_options(),
			'public'     => -1,
			'visibility' => 'view',
			'required'   => 0,
			'editable'   => 0,
			'icon'       => 'um-faicon-shopping-cart',
		);

		return $fields;
	}


	/**
	 * Filter the "Bought products" field data in the "view" mode.
	 *
	 * Hook: um_get_field__{$key}
	 *
	 * @see \um\core\Fields::get_field()
	 *
	 * @param  array $data Field Data.
	 * @return array
	 */
	public function filter_field_data( $data ) {
		if ( 'woo_bought_products' === $data['metakey'] ) {
			$data['options'] = $this->get_options();
		}
		return $data;
	}


	/**
	 * Filter the "Bought products" field keyword flag.
	 *
	 * Hook: um_select_options_pair
	 *
	 * @see \um\core\Fields::edit_field()
	 *
	 * @param int|null $use_keyword If 1 - keyword is enabled. It's 0 by default.
	 * @param array    $data        Field data.
	 *
	 * @return int
	 */
	public function filter_use_keyword( $use_keyword, $data ) {
		if ( is_array( $data ) && array_key_exists( 'metakey', $data ) && 'woo_bought_products' === $data['metakey'] ) {
			$use_keyword = true;
		} elseif ( is_string( $data ) && 'woo_bought_products' === $data ) {
			$use_keyword = true;
		}
		return $use_keyword;
	}


	/**
	 * Filter the "Bought products" field options.
	 *
	 * Hook: um_multiselect_options_{$key}
	 *
	 * @see \um\core\Fields::edit_field()
	 *
	 * @param  array $options Options array.
	 *
	 * @return array
	 */
	public function get_options( $options = array() ) {
		if ( empty( $this->options ) ) {
			$this->options = array();

			$products = get_posts(
				array(
					'nopaging'    => true,
					'post_status' => 'publish',
					'post_type'   => 'product',
				)
			);

			foreach ( $products as $product ) {
				$this->options[ $product->ID ] = $product->post_title;
			}
			asort( $this->options );
		}

		return $this->options;
	}

}
