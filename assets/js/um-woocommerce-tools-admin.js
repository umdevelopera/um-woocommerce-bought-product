/* wp-admin scripts for the "Ultimate Member - WooCommerce Tools" plugin. */

jQuery( function () {
	var wcbp_data = window.um_wcbp_update || {};
	var wcbp_form = document.forms['um-wcbp-form'];
	var wcbp_tmpl = wp.template( 'wcbp-progress' );

	if ( wcbp_data.state === 'run' ) {
		jQuery( '#wcbpu_progress' ).replaceWith( wcbp_tmpl( wcbp_data ) );
		wcbp_ajax_run();
	}

	jQuery( wcbp_form )
			.on( 'submit', wcbp_start )
			.on( 'click', '#wcbpu_start', wcbp_start )
			.on( 'click', '#wcbpu_run', wcbp_run )
			.on( 'click', '#wcbpu_pause', wcbp_pause )
			.on( 'click', '#wcbpu_stop', wcbp_stop );

	function wcbp_ajax_run() {
		if ( wcbp_data.state !== 'run' ) {
			return;
		}

		jQuery( '#wcbpu_role,#wcbpu_start' ).attr( 'disabled', true ).next( '.spinner' ).css( 'visibility', 'visible' );

		var data = {
			user_role: wcbp_form.elements.user_role.value,
			action: wcbp_form.elements.action.value,
			_wpnonce: wcbp_form.elements._wpnonce.value
		};

		return wp.ajax.post( data.action, data )
				.done( function ( response ) {
					if ( 'object' === typeof response ) {
						if ( 'done' === response.state ) {
							jQuery( '#wcbpu_role,#wcbpu_start' ).attr( 'disabled', false ).next( '.spinner' ).css( 'visibility', 'hidden' );
						} else
						if ( 'error' === response.state ) {
							jQuery( '#wcbpu_role,#wcbpu_start' ).attr( 'disabled', false ).next( '.spinner' ).css( 'visibility', 'hidden' );
							response.state = '';
						}  else
						if ( 'pause' === wcbp_data.state ) {
							response.state = 'pause';
						} else
						if ( 'run' === wcbp_data.state ) {
							wcbp_ajax_run();
						}

						jQuery.extend( wcbp_data, response );
						jQuery( '#wcbpu_progress' ).replaceWith( wcbp_tmpl( wcbp_data ) );

						wp.hooks.doAction( 'um_wcbp_ajax_run_done', response );
					}
				} )
				.fail( function ( response ) {
					console.warn( 'UM - Terms & Conditions: wcbp_ajax_run', response );
				} );
	}

	function wcbp_ajax_stop() {

		var data = {
			action: 'um_wcbp_update_stop',
			_wpnonce: wcbp_form.elements._wpnonce.value
		};

		return wp.ajax.post( data.action, data )
				.done( function ( response ) {
					jQuery( '#wcbpu_role,#wcbpu_start' ).attr( 'disabled', false ).next( '.spinner' ).css( 'visibility', 'hidden' );
					jQuery( '#wcbpu_progress' ).html( '' );

					wp.hooks.doAction( 'um_wcbp_ajax_stop_done', response );
				} )
				.fail( function ( response ) {
					console.warn( 'UM - Terms & Conditions: wcbp_ajax_stop', response );
				} );
	}

	function wcbp_pause( e ) {
		e.preventDefault();
		if ( wcbp_data.state === 'run' ) {
			wcbp_data.state = 'pause';
			jQuery( '#wcbpu_start' ).next( '.spinner' ).css( 'visibility', 'hidden' );
			jQuery( '#wcbpu_progress' ).replaceWith( wcbp_tmpl( wcbp_data ) );
		}
	}

	function wcbp_run( e ) {
		e.preventDefault();
		if ( wcbp_data.state === 'pause' ) {
			wcbp_data.state = 'run';
			jQuery( '#wcbpu_start' ).next( '.spinner' ).css( 'visibility', 'visible' );
			jQuery( '#wcbpu_progress' ).replaceWith( wcbp_tmpl( wcbp_data ) );
			wcbp_ajax_run();
		}
	}

	function wcbp_start( e ) {
		e.preventDefault();
		if ( wcbp_data.state !== 'run' ) {
			wcbp_data.state = 'run';
			jQuery( '#wcbpu_progress' ).html( '' );
			wcbp_ajax_run();
		}
	}

	function wcbp_stop( e ) {
		e.preventDefault();
		wcbp_data.state = '';
		jQuery( '#wcbpu_progress' ).html( '' );
		wcbp_ajax_stop();
	}

} );