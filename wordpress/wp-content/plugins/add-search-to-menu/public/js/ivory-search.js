( function( $ ) {
	'use strict';

	$( document ).ready( function() {

		$( '.is-menu a' ).on( 'click', function( e ) {

			 // Cancels the default actions.
			e.stopPropagation();
			e.preventDefault();

			if ( 'static' === $( this ).parent().parent().css( 'position' ) ) {
				$( this ).parent().parent().css( 'position', 'relative' );
			}

			if ( $( this ).closest( '.is-menu-wrapper' ).length ) {
				if ( $( this ).parent().hasClass( 'sliding' ) || $( this ).parent().hasClass( 'full-width-menu' ) ) {
					$( this ).closest( '.is-menu-wrapper' ).addClass( 'is-expanded' );
				}
			}

			if ( $( this ).parent().hasClass( 'is-dropdown' ) ) {
				$( this ).parent().find( 'form' ).fadeToggle();
			} else if ( $( this ).parent().hasClass( 'sliding' ) ) {
				$( this ).parent().find( 'form' ).animate( { width: '310' } );
				$( this ).parent().find( 'form input[type="search"], form input[type="text"]' ).focus();
				$( this ).parent().addClass( 'open' );
			} else if ( $( this ).parent().hasClass( 'full-width-menu' ) ) {
				$( this ).parent().addClass( 'active-search' );
				$( this ).parent().find( 'form' ).animate( { width: '100%' } );
				$( this ).parent().addClass( 'open' );
				$( this ).parent().find( 'form input[type="search"], form input[type="text"]' ).focus();
			} else if ( $( this ).parent().hasClass( 'popup' ) ) {
				$( '#is-popup-wrapper' ).show();
				$( '#is-popup-wrapper form input[type="text"], #is-popup-wrapper form input[type="search"]' ).focus();
			}

			$(this).closest('.is-menu').find( 'form input[type="search"], form input[type="text"]' ).focus();
		} );

		$( '#is-popup-wrapper' ).on( 'click', function( e ) {
			if ( ! $(e.target).closest('form').length ) {
				$( '#is-popup-wrapper, .is-ajax-search-result, .is-ajax-search-details' ).hide();
			}
		} );
	} );

	$( document ).keyup( function( e ) {
		if ( e.keyCode === 27 ) {
			$( '#is-popup-wrapper, .is-ajax-search-result, .is-ajax-search-details' ).hide();
		}
	} );

	$( '.is-menu form input[type="search"], .is-menu form input[type="text"]' ).on( 'click', function( e ) {
		 e.stopPropagation();
		return false;
	} );

	$( 'form.is-search-form, form.search-form' ).on( 'hover', function( e ) {
		if ( $( this ).next( ".is-link-container" ).length ){
            $( this ).append( $( this ).next( ".is-link-container" ).remove() );
		}
	} );

	$( window ).click( function( e ) {
		if ( 0 === e.button && 0 === $( e.target ).closest( '.is-ajax-search-result' ).length && 0 === $( e.target ).closest( '.is-ajax-search-details' ).length ) {
			if ( $( '.is-menu' ).hasClass( 'open' ) ) {
				$( '.is-menu form' ).animate(
					{ width: '0' },
					400,
					function() {
						$( '.is-menu' ).removeClass( 'active-search' );
						$( '.is-menu' ).removeClass( 'open' );
						$( '.is-menu-wrapper' ).removeClass( 'is-expanded' );
					}
				);
			} else if ( $( '.is-menu' ).hasClass( 'is-dropdown' ) ) {
				$( '.is-menu form' ).fadeOut();
			}
		}
	});
} )( jQuery );