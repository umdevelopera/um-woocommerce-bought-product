<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $wcbpu ) ) {
	wp_localize_script( 'um-woocommerce-bought-product-admin', 'um_wcbp_update', $wcbpu );
}
wp_enqueue_script( 'um-woocommerce-bought-product-admin' );
wp_enqueue_style( 'um-woocommerce-bought-product-admin' );
?>

<form method="post" name="um-wcbp-form" class="um-wcbp-form">
	<p class="sub">
		<?php esc_html_e( 'Create or update bought products usermeta', 'um-woocommerce-bought-product' ); ?>
		<span class="um_tooltip dashicons dashicons-editor-help" title="<?php esc_attr_e( 'This tool updates information about purchased products for members with selected role(s).', 'um-woocommerce-bought-product' ); ?>"></span>
	</p>

	<select id="wcbpu_role" name="user_role" <?php echo $wcbpu['state'] ? 'disabled' : ''; ?>>
		<option value=""><?php esc_html_e( '~All Roles~', 'um-woocommerce-bought-product' ); ?></option>
		<?php foreach ( UM()->roles()->get_roles() as $role_id => $role_title ) { ?>
			<option value="<?php echo esc_attr( $role_id ); ?>" <?php selected( $wcbpu['role'], $role_id ); ?>><?php echo esc_html( $role_title ); ?></option>
		<?php } ?>
	</select>
	<button id="wcbpu_start" class="button" type="submit" <?php echo $wcbpu['state'] ? 'disabled' : ''; ?>>
		<?php esc_html_e( 'Start', 'um-woocommerce-bought-product' ); ?>
	</button>
	<span class="spinner"></span>

	<div id="wcbpu_progress"></div>

	<input type="hidden" name="action" value="um_wcbp_update">
	<?php wp_nonce_field( 'um_wcbp_update' ); ?>
</form>

<script type="text/html" id="tmpl-wcbp-progress">
	<div id="wcbpu_progress">
		<# if( data.error ) { #>
			<div class="um-wcbp-notice um-wcbp-notice-error">{{data.error}}</div>
		<# } #>
		<# if( data.success ) { #>
			<div class="um-wcbp-notice um-wcbp-notice-success">{{data.success}}</div>
		<# } #>
		<# if( data.total ) { #>
			<div class="um-wcbp-progress-bar">
				<div class="um-wcbp-progress-bar-done" style="width:{{data.done}}"></div>
			</div>
			<# if( 'done' !== data.state ) { #>
				<button id="wcbpu_run" class="button" type="button" <# if( 'run' === data.state ) { print( 'disabled' ) } #>>
					<?php esc_html_e( 'Run', 'um-woocommerce-bought-product' ); ?>
				</button>
				<button id="wcbpu_pause" class="button" type="button" <# if( 'pause' === data.state ) { print( 'disabled' ) } #>>
					<?php esc_html_e( 'Pause', 'um-woocommerce-bought-product' ); ?>
				</button>
				<button id="wcbpu_stop" class="button" type="button">
					<?php esc_html_e( 'Cancel', 'um-woocommerce-bought-product' ); ?>
				</button>
			<# } #>
		<# } #>
	</div>
</script>
