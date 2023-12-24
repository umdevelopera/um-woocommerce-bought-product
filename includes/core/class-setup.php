<?php
/**
 * Sets default settings on installation.
 *
 * @package um_ext\um_woocommerce_bought_product\core
 */

namespace um_ext\um_woocommerce_bought_product\core;

use Automattic\WooCommerce\Utilities\OrderUtil;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Setup
 *
 * @package um_ext\um_woocommerce_bought_product\core
 */
class Setup {


	/**
	 * Setup constructor.
	 */
	public function __construct() {
	}


	/**
	 * Run on plugin activation.
	 */
	public function run() {
		$this->update_user_data();
	}


	/**
	 * Update user data.
	 */
	public function update_user_data() {
		global $wpdb;

		$statuses = array_map( 'esc_sql', wc_get_is_paid_statuses() );

		if ( OrderUtil::custom_orders_table_usage_is_enabled() ) {
			// HPOS usage is enabled.
			$sql = "
SELECT o.id AS order_id, im.meta_value AS product_id, o.customer_id AS user_id
FROM {$wpdb->prefix}wc_orders AS o
INNER JOIN {$wpdb->prefix}woocommerce_order_items AS i ON ( o.id = i.order_id AND o.customer_id != 0 AND i.order_item_type = 'line_item' )
INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS im ON ( i.order_item_id = im.order_item_id AND im.meta_key IN ( '_product_id', '_variation_id' ) )
WHERE o.type = 'shop_order'
	AND o.status IN ( 'wc-" . implode( "','wc-", $statuses ) . "' )
	AND im.meta_value != 0
			";
		} else {
			// Traditional CPT-based orders are in use.
			$sql = "
SELECT p.ID AS order_id, im.meta_value AS product_id, pm.meta_value AS user_id
FROM {$wpdb->posts} AS p
INNER JOIN {$wpdb->postmeta} AS pm ON ( p.post_type = 'shop_order' AND p.ID = pm.post_id AND pm.meta_key = '_customer_user' AND pm.meta_value != '0' )
INNER JOIN {$wpdb->prefix}woocommerce_order_items AS i ON ( p.ID = i.order_id AND i.order_item_type = 'line_item' )
INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS im ON ( i.order_item_id = im.order_item_id AND im.meta_key IN ( '_product_id', '_variation_id' ) )
WHERE p.post_type = 'shop_order'
	AND p.post_status IN ( 'wc-" . implode( "','wc-", $statuses ) . "' )
	AND im.meta_value != 0
			";
		}

		$results = $wpdb->get_results( $sql );

		$user_products = array();
		foreach ( $results as $result ) {
			if ( ! array_key_exists( $result->user_id, $user_products ) ) {
				$user_products[ $result->user_id ] = array();
			}
			$user_products[ $result->user_id ][] = $result->product_id;
		}

		foreach ( $user_products as $user_id => $products ) {
			if ( ! empty( $user_id ) ) {
				$woo_bought_products = array_unique( $products );
				update_user_meta( $user_id, 'woo_bought_products', $woo_bought_products );
			}
		}
	}

}
