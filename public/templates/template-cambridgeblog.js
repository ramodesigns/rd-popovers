/**
 * JavaScript for the Cambridge Blog template.
 * Handles email form submission.
 */

(function() {
	'use strict';

	function initCambridgeBlogForms() {
		var forms = document.querySelectorAll( '.spt-cb-form' );

		forms.forEach( function( form ) {
			form.addEventListener( 'submit', function( e ) {
				e.preventDefault();

				var input    = form.querySelector( '.spt-cb-email' );
				var thankyou = form.closest( '.spt-cb-body' ).querySelector( '.spt-cb-thankyou' );

				if ( ! input || ! input.value || ! input.validity.valid ) {
					input.focus();
					return;
				}

				// Hide form, show thank-you message.
				form.style.display = 'none';
				if ( thankyou ) {
					thankyou.textContent = "Thanks! We'll be in touch within 24 hours.";
					thankyou.classList.add( 'spt-cb-visible' );
				}
			} );
		} );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', initCambridgeBlogForms );
	} else {
		initCambridgeBlogForms();
	}
})();
