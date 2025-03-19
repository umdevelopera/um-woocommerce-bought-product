<?php
defined( 'ABSPATH' ) || exit;

wp_localize_script( 'um-woocommerce-tools-admin', 'um_wcbp_update', $wcbpu );
wp_enqueue_script( 'um-woocommerce-tools-admin' );
wp_enqueue_style( 'um-woocommerce-tools-admin' );

include_once 'tmpl/wcbp-progress.php';
?>

<form method="post" name="um-wcbp-form" class="um-wcbp-form">
	<p class="sub">
		<?php esc_html_e( 'Create or update bought products usermeta', 'um-woocommerce-tools' ); ?>
		<span class="um_tooltip dashicons dashicons-editor-help" title="<?php esc_attr_e( 'This tool updates information about purchased products for members with selected role(s).', 'um-woocommerce-tools' ); ?>"></span>
	</p>

	<select id="wcbpu_role" name="user_role" <?php echo $wcbpu['state'] ? 'disabled' : ''; ?>>
		<option value=""><?php esc_html_e( '~All Roles~', 'um-woocommerce-tools' ); ?></option>
		<?php foreach ( UM()->roles()->get_roles() as $role_id => $role_title ) { ?>
			<option value="<?php echo esc_attr( $role_id ); ?>" <?php selected( $wcbpu['role'], $role_id ); ?>><?php echo esc_html( $role_title ); ?></option>
		<?php } ?>
	</select>
	<button id="wcbpu_start" class="button" type="submit" <?php echo $wcbpu['state'] ? 'disabled' : ''; ?>>
		<?php esc_html_e( 'Start', 'um-woocommerce-tools' ); ?>
	</button>

	<div id="wcbpu_progress"></div>

	<input type="hidden" name="action" value="um_wcbp_update">
	<?php wp_nonce_field( 'um_wcbp_update' ); ?>
</form>
