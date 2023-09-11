<?php
namespace um_ext\um_woocommerce_bought_product\admin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class that extends Ultimate Member dashboard.
 *
 * @usage UM()->classes['um_woocommerce_bought_product_dashboard']
 * @usage UM()->Woocommerce_Bought_Product()->dashboard()
 *
 * @package um_ext\um_woocommerce_bought_product\admin
 * @since 1.1.0
 */
class Dashboard {

	/**
	 * A number of users updated per iteration.
	 *
	 * @var int
	 */
	protected $users_per_once = 3;

	/**
	 * Products IDs.
	 *
	 * @var array
	 */
	private $products;


	/**
	 * Class constructor
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
		add_action( 'admin_menu', array( $this, 'prepare_metabox' ), 20 );

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			add_action( 'wp_ajax_um_wcbp_update', array( &$this, 'ajax_do_update' ) );
			add_action( 'wp_ajax_um_wcbp_update_stop', array( &$this, 'ajax_do_update_stop' ) );
		}
	}


	/**
	 * AJAX action. Update the woo_bought_products user meta
	 */
	public function ajax_do_update() {
		check_ajax_referer( 'um_wcbp_update' );

		$wcbpu = $this->do_update();
		if ( is_array( $wcbpu ) && array_key_exists( 'users', $wcbpu ) ) {
			unset( $wcbpu['users'] );
			wp_send_json_success( $wcbpu );
		}
	}


	/**
	 * AJAX action. Stop updating the woo_bought_products user meta
	 */
	public function ajax_do_update_stop() {
		check_ajax_referer( 'um_wcbp_update' );
		delete_option( 'um_wcbp_update' );
		wp_send_json_success( true );
	}


	/**
	 * Action. Send agreement notification.
	 *
	 * @return array|string
	 */
	public function do_update() {
		check_admin_referer( 'um_wcbp_update' );

		$wcbpu = get_option( 'um_wcbp_update' );
		if ( empty( $wcbpu ) ) {
			$wcbpu = $this->get_wcbpu_def();
			$role = empty( $_REQUEST['user_role'] ) ? '' : sanitize_key( wp_unslash( $_REQUEST['user_role'] ) );
			$args = array(
				'fields' => 'id',
				'role'   => $role,
			);

			$users = get_users( $args );

			if ( empty( $users ) ) {
				$wcbpu['error'] = __( 'There are no members who match criteria.', 'um-woocommerce-bought-product' );
				$wcbpu['state'] = 'error';
			} else {
				$wcbpu['role']  = $role;
				$wcbpu['total'] = count( $users );
				$wcbpu['users'] = $users;
			}
		}

		if ( $wcbpu['users'] ) {
			$users = array_slice( $wcbpu['users'], $wcbpu['sent'], $this->users_per_once );

			if ( empty( $users ) ) {
				$wcbpu['error'] = __( 'Can not get users.', 'um-woocommerce-bought-product' );
				$wcbpu['state'] = 'error';
			} else {

				foreach ( $users as $user_id ) {
					$bought_products = $this->get_bought_products( $user_id );
					if ( empty( $bought_products ) ) {
						delete_user_meta( $user_id, 'woo_bought_products' );
					} else {
						update_user_meta( $user_id, 'woo_bought_products', $bought_products );
					}
				}

				$wcbpu['sent'] += count( $users );
				$wcbpu['done']  = ceil( 100 * $wcbpu['sent'] / $wcbpu['total'] ) . '%';
				$wcbpu['state'] = $wcbpu['sent'] < $wcbpu['total'] ? 'run' : 'done';

				if ( 'done' === $wcbpu['state'] ) {
					$wcbpu['success']  = __( 'DONE.', 'um-woocommerce-bought-product' );
					$wcbpu['success'] .= PHP_EOL;
					$wcbpu['success'] .= sprintf( _n( 'Information has been updated for %1$d member.', 'Information has been updated for %1$d members.', $wcbpu['total'], 'um-woocommerce-bought-product' ), $wcbpu['sent'] );
					delete_option( 'um_wcbp_update' );
				} else {
					$wcbpu['success']  = __( 'User meta are updating. Progress ', 'um-woocommerce-bought-product' ) . $wcbpu['done'];
					$wcbpu['success'] .= PHP_EOL;
					$wcbpu['success'] .= sprintf( _n( 'Information has been updated for %1$d of %2$d member.', 'Information has been updated for %1$d of %2$d members.', $wcbpu['total'], 'um-woocommerce-bought-product' ), $wcbpu['sent'], $wcbpu['total'] );
					update_option( 'um_wcbp_update', $wcbpu );
				}
			}
		}

		return $wcbpu;
	}


	/**
	 * Register wp-admin scripts and styles
	 */
	public function enqueue_scripts() {
		wp_register_script( 'um-woocommerce-bought-product-admin', um_woocommerce_bought_product_url . 'assets/js/um-woocommerce-bought-product-admin.js', array( 'jquery', 'wp-hooks' ), um_woocommerce_bought_product_version, false );
		wp_register_style( 'um-woocommerce-bought-product-admin', um_woocommerce_bought_product_url . 'assets/css/um-woocommerce-bought-product-admin.css', array(), um_woocommerce_bought_product_version );
	}


	/**
	 * Get products purchased by this user.
	 *
	 * @param  int $user_id User ID.
	 * @return array
	 */
	public function get_bought_products( $user_id ) {
		$user = get_userdata( $user_id );

		$bought_products = array();
		foreach ( $this->get_products() as $product_id ) {
			if( wc_customer_bought_product( $user->user_email, $user_id, $product_id ) ) {
				$bought_products[] = $product_id;
			}
		}

		return $bought_products;
	}


	/**
	 * Get an array of products.
	 *
	 * @return array
	 */
	public function get_products() {
		if ( empty( $this->products ) ) {
			$this->products = get_posts(
				array(
					'fields'      => 'ids',
					'post_type'   => 'product',
					'numberposts' => -1,
				)
			);
		}
		return $this->products;
	}


	/**
	 * Get default data for the "Update the woo_bought_products user meta" dashboard tool.
	 *
	 * @return array
	 */
	public function get_wcbpu_def() {
		return array(
			'done'    => '0%',
			'error'   => '',
			'role'    => '',
			'sent'    => 0,
			'state'   => '',
			'success' => '',
			'total'   => 0,
			'users'   => array(),
		);
	}


	/**
	 * Load metabox
	 */
	public function load_metabox() {
		add_meta_box( 'um-metaboxes-wcbp', __( 'WooCommerce (bought products)', 'um-woocommerce-bought-product' ), array( &$this, 'metabox_content' ), 'toplevel_page_ultimatemember', 'normal', 'default' );
	}


	/**
	 * Render metabox
	 */
	public function metabox_content() {
		$template = wp_normalize_path( um_woocommerce_bought_product_path . 'includes/admin/templates/dashboard.php' );
		if ( file_exists( $template ) ) {
			$wcbpu = get_option( 'um_wcbp_update' );
			if ( empty( $wcbpu ) ) {
				$wcbpu = $this->get_wcbpu_def();
			}
			include $template;
		}
	}

	/**
	 * Add metabox
	 */
	public function prepare_metabox() {
		add_action( 'load-toplevel_page_ultimatemember', array( &$this, 'load_metabox' ) );
	}

}
