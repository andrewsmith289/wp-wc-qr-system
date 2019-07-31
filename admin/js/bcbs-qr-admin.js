(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(function() {
        $( "#do-qr-print" ).click(function(e) {
            // alert( "Handler for .click() called." );
            var data = $( "#_qr_data" ).val();
            var size = $( "#_qr_print_size" ).val();
            var count = $( "#_qr_print_qty" ).val();

            var is_variable = $( "#_qr_is_variable" ).val();

            if ( is_variable ) {
                var selected_var = $( "#_qr_print_var_id" ).val();
                data += ',v' + selected_var;
            }
            var uri = encodeURI( "https://dev.***********/qr/?qr_data=" + data + "&qr_count=" + count + "&qr_size=" + size );
            // window.location.href = "https://dev.***********/qr/?qr_data=" + data + "&qr_count=" + count + "&qr_size=" + size;
            window.open( uri );

            e.preventDefault();
        });
    });


})( jQuery );
