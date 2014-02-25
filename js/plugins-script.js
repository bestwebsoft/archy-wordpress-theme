(function( $ ) {

	$(document).ready(function() {

		/* *** *** BWS Gallery Plugin *** *** */

		/* if image size is bigger than content width change size of the image to appropriate */

		if( $( '.gllr_image_block' ) ) {
			var imgGal = $( '.gllr_image_block img' );

			/* normalizes gallery image in widgets area */

			if( imgGal.outerWidth() > $( '#secondary' ).width() ) {
				imgGal.not( 'article img, #archy-content img' ).css( 'box-sizing', 'border-box' );
				$( '#secondary .gllr_image_block p' ).css( 'height', imgGal.outerHeight() );
			}

			/* normalizes gallery image in content area (posts, pages, gallery-post) */

			if( ( $( 'article' ).length !== 0 && imgGal.not( '#secondary img' ).outerWidth() > $( 'article' ).width() )
				|| ( $( '#archy-content' ).length !== 0 && imgGal.not( '#secondary img' ).outerWidth() > $( '#archy-content' ).width() ) ) {
				imgGal.not( '#secondary img' ).css( { 
					'box-sizing' : 'border-box',
					'-moz-box-sizing' : 'border-box',
					'-webkit-box-sizing' : 'border-box'
				});
				$( 'article .gllr_image_block p, #archy-content .gllr_image_block p' ).css( 'height', imgGal.outerHeight() );
			}
		}


		/* *** *** BWS Portfolio Plugin *** *** */

		if( $( '.single-portfolio' ).not( '.widget img' ) ) {

			/* changes float of portfolio content if it have any images or if thumb image bigger than 350px */

			if( $( '.portfolio_short_content img' ).not( '.widget img' ).length > 0 
				|| $( '.portfolio_thumb img' ).not( '.widget img' ).width() > 350 ) {
				$( '.portfolio_short_content' ).not( '.widget .portfolio_short_content' ).css( 'float', 'left' );

				if( $( '.portfolio_thumb img' ).not( '.widget img' ).width() > 350 ) {
					$( '.portfolio_thumb' ).css( 'margin-bottom', '15px' );
				}
			}

			/* optimizes screenshots in "more screenshoots" block if it's height don't correspond to the user settings */

			$( '.portfolio_content .portfolio_thumb img' ).not( '.widget img' ).css( 'height', $( '.portfolio_content .portfolio_thumb img' ).attr( 'height' ) );

			$( '.portfolio_images_block img' ).not( '.widget img' ).css( 'height', $( '.portfolio_images_block img' ).attr( 'height' ) );

		}

	});

} )( jQuery );