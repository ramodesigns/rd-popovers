/**
 * Scroll-triggered popup functionality for RD Popovers plugin.
 *
 * Triggers at a configurable scroll depth (default 30%), or immediately if the page isn't scrollable.
 * Uses session storage to show only once per session.
 *
 * @package    Rd_Popovers
 * @subpackage Rd_Popovers/public/js
 */

(function() {
	'use strict';

	var SESSION_KEY = 'spt_popup_shown';

	function ScrollPopupTrigger( popupElement ) {
		this.popup           = popupElement;
		this.hasTriggered    = false;
		this.delay           = parseInt( this.popup.dataset.delay, 10 ) || 0;
		this.scrollThreshold = ( parseInt( this.popup.dataset.scroll, 10 ) || 30 ) / 100;
		this.init();
	}

	ScrollPopupTrigger.prototype.init = function() {
		if ( sessionStorage.getItem( SESSION_KEY + '_' + this.popup.id ) ) {
			return;
		}

		if ( ! this.isPageScrollable() ) {
			this.showPopup();
		} else {
			this.attachScrollListener();
		}

		this.attachCloseHandlers();
	};

	ScrollPopupTrigger.prototype.isPageScrollable = function() {
		var documentHeight = Math.max(
			document.body.scrollHeight,
			document.body.offsetHeight,
			document.documentElement.clientHeight,
			document.documentElement.scrollHeight,
			document.documentElement.offsetHeight
		);
		return documentHeight > window.innerHeight;
	};

	ScrollPopupTrigger.prototype.attachScrollListener = function() {
		var self    = this;
		var ticking = false;

		var handleScroll = function() {
			if ( ! ticking && ! self.hasTriggered ) {
				window.requestAnimationFrame( function() {
					self.checkScrollPosition();
					ticking = false;
				} );
				ticking = true;
			}
		};

		window.addEventListener( 'scroll', handleScroll, { passive: true } );

		window.addEventListener( 'resize', function() {
			if ( ! self.hasTriggered && ! self.isPageScrollable() ) {
				self.showPopup();
			}
		}, { passive: true } );
	};

	ScrollPopupTrigger.prototype.checkScrollPosition = function() {
		var scrollTop      = window.pageYOffset || document.documentElement.scrollTop;
		var windowHeight   = window.innerHeight;
		var documentHeight = Math.max(
			document.body.scrollHeight,
			document.documentElement.scrollHeight
		);

		var scrollableHeight = documentHeight - windowHeight;
		var scrollPercentage = scrollTop / scrollableHeight;

		if ( scrollPercentage >= this.scrollThreshold ) {
			this.showPopup();
		}
	};

	ScrollPopupTrigger.prototype.showPopup = function() {
		if ( this.hasTriggered ) {
			return;
		}

		this.hasTriggered = true;
		var self = this;

		setTimeout( function() {
			self.popup.classList.add( 'spt-active' );
			self.popup.setAttribute( 'aria-hidden', 'false' );
			document.body.style.overflow = 'hidden';

			var focusableElements = self.popup.querySelectorAll(
				'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
			);
			if ( focusableElements.length > 0 ) {
				focusableElements[0].focus();
			}
		}, this.delay );
	};

	ScrollPopupTrigger.prototype.closePopup = function() {
		this.popup.classList.remove( 'spt-active' );
		this.popup.setAttribute( 'aria-hidden', 'true' );
		document.body.style.overflow = '';

		sessionStorage.setItem( SESSION_KEY + '_' + this.popup.id, 'true' );
	};

	ScrollPopupTrigger.prototype.attachCloseHandlers = function() {
		var self = this;

		var closeBtn = this.popup.querySelector( '.spt-popup-close' );
		if ( closeBtn ) {
			closeBtn.addEventListener( 'click', function( e ) {
				e.preventDefault();
				self.closePopup();
			} );
		}

		this.popup.addEventListener( 'click', function( e ) {
			if ( e.target === self.popup ) {
				self.closePopup();
			}
		} );

		document.addEventListener( 'keydown', function( e ) {
			if ( e.key === 'Escape' && self.popup.classList.contains( 'spt-active' ) ) {
				self.closePopup();
			}
		} );
	};

	function initPopups() {
		var popups = document.querySelectorAll( '.spt-popup-overlay' );
		popups.forEach( function( popup ) {
			new ScrollPopupTrigger( popup );
		} );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', initPopups );
	} else {
		initPopups();
	}
})();
