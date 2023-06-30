<?php
/**
 * Extend predefined order.
 *
 * @package um_ext\um_woocommerce_bought_product\core
 */

namespace um_ext\um_woocommerce_bought_product\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Extend predefined order.
 *
 * @package um_ext\um_woocommerce_bought_product\core
 */
class Order {


	/**
	 * Class Order constructor.
	 */
	public function __construct() {
		add_action( 'woocommerce_order_status_changed', array( $this, 'update_user_data' ), 10, 4 );
	}


	/**
	 * Update user data.
	 *
	 * @global \wpdb $wpdb
	 * @param int       $order_id    Order ID.
	 * @param string    $status_from Old order status.
	 * @param string    $status_to   New order status.
	 * @param \WC_Order $order       Order object.
	 */
	public function update_user_data( $order_id, $status_from, $status_to, $order ) {
		global $wpdb;

		$user_id  = $order->get_user_id();
		$statuses = array_map( 'esc_sql', wc_get_is_paid_statuses() );

		$sql = "
SELECT p.ID AS order_id, im.meta_value AS product_id, pm.meta_value AS user_id
FROM {$wpdb->posts} AS p
INNER JOIN {$wpdb->postmeta} AS pm ON ( p.ID = pm.post_id AND p.post_type = 'shop_order' AND pm.meta_key = '_customer_user' AND pm.meta_value = {$user_id} )
INNER JOIN {$wpdb->prefix}woocommerce_order_items AS i ON ( p.ID = i.order_id AND i.order_item_type = 'line_item' )
INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS im ON ( i.order_item_id = im.order_item_id AND im.meta_key IN ( '_product_id', '_variation_id' ) )
WHERE p.post_status IN ( 'wc-" . implode( "','wc-", $statuses ) . "' ) AND im.meta_value != 0
		";

		$results = $wpdb->get_results( $sql );

		$products = array();
		foreach ( $results as $result ) {
			$products[] = $result->product_id;
		}
		$woo_bought_products = array_unique( $products );
		update_user_meta( $user_id, 'woo_bought_products', $woo_bought_products );
	}

}
