<script type="text/html" id="tmpl-wcbp-progress">
	<div id="wcbpu_progress">
		<# if( 'run' === data.state ) { #><span class="spinner"></span><# } #>
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
				<button id="wcbpu_run" class="button" type="button" <# if( 'run' === data.state ) { #>disabled<# } #>>
					<?php esc_html_e( 'Run', 'um-woocommerce-tools' ); ?>
				</button>
				<button id="wcbpu_pause" class="button" type="button" <# if( 'pause' === data.state ) { #>disabled<# } #>>
					<?php esc_html_e( 'Pause', 'um-woocommerce-tools' ); ?>
				</button>
				<button id="wcbpu_stop" class="button" type="button">
					<?php esc_html_e( 'Cancel', 'um-woocommerce-tools' ); ?>
				</button>
			<# } #>
		<# } #>
	</div>
</script>