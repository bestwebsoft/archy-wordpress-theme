( function( $ ) {

	$(document).ready(function() {

		/* *** *** Placaholder realization *** *** */
		$( '.searchform' ).each(function() {
			var lbl = $( this ).find( 'label[for="s"]' ); /* label */
			var inp = $( this ).find( 'input[name="s"]' ); /* input */
			lbl.text( 'Enter search keyword' );
			inp.val() == '' ? lbl.show() : lbl.hide();
			inp.focusin(function() {
				$( this ).parent().children( 'label[for="s"]' ).hide(); /* not prev() - IE not supported it */
			});
			inp.focusout(function() {
				if( !$( this ).val().length ) {
					$( this ).parent().children( 'label[for="s"]' ).show();
				}
			});
			lbl.click(function(event) {
				event = event || window.event;
				/* not next() - IE not work great with it */
				$( this ).parent().children( 'input[name="s"]' ).focus(); /* input[name="s"] */
				event.preventDefault();
			});
		});

		/* *** *** Scroll to top *** *** */
		$( 'a[href="#wrapper"]' ).on( 'click', function(e) {
			e.preventDefault();
			//html - IE, FF, body - Chrome, Safari
			$( 'html, body' ).animate({
				scrollTop: $( '#wrapper' ).offset().top
			}, 500);
		});


		/* *** *** Create custom select-menu *** *** */
		$( 'select' ).each(function(key, val) {
			var selectDiv = document.createElement( 'div' ); /* create div element */
			selectDiv.className = 'archy-select-block';
			$( selectDiv ).mousemove(function() { /* reset selected class from choosed element */
				$( this ).find( '.archy-option.selected' ).removeClass( 'selected' );
			});
			var mainSelect = $( val ); /* get select element */
			mainSelect.hide(); /* hide all options */
			var fakeSelect = document.createElement( 'div' );
			fakeSelect.className = 'archy-select';
			fakeSelect.setAttribute( 'name', $( mainSelect ).attr( 'name' ) );
			var header = document.createElement( 'h1' );
			header.innerHTML = $( mainSelect ).find( 'option:selected' ).text();
			header.className = 'archy-index-' + $( mainSelect )[0].selectedIndex;
			fakeSelect.appendChild( header ); /* add h1 element to select instrument */
			var counterOptions = 0;
			mainSelect.find( '*' ).each(function(k, v) {
				var elem = document.createElement( 'div' );
				if( v.tagName == 'OPTGROUP' ) {
					elem.className = 'archy-optgroup'; /* create optgroup div */

					var h1 = document.createElement( 'h1' );
					h1.innerHTML = $( v ).attr( 'label' );
					h1.className = 'archy-optgroup-h1';

					elem.appendChild( h1 );
				} else {
					elem.className = 'archy-option'; /* create option div */
					$( elem ).addClass( 'archy-index-' + counterOptions++ );

					elem.innerHTML = $( v ).text(); /* set content of select item */
					elem.setAttribute( 'title', elem.innerHTML );
					elem.setAttribute( 'value', $( v ).attr( 'value' ) );

					elem.onclick = function() {
						if( !( $( this ).attr( 'class' ).indexOf( $( fakeSelect ).children( 'h1' ).attr( 'class' ) ) > 0 ) ) {
							/* h1 changes */
							$( fakeSelect ).children( 'h1' ).text( $( this ).text() );
							$( fakeSelect ).children( 'h1' ).attr( 'value', $( this ).attr( 'value' ) );
							$( fakeSelect ).children( 'h1' ).get( 0 ).className = $( this ).attr( 'class' ).match( /archy-index-\d+/, 'g' ); /* get index */

							mainSelect.prop( 'selectedIndex', $( this ).attr( 'class' ).split( '-' )[1] ).change();
						}
						var selElementIndex = $( this ).index();
						$( this ).parent().parent().prev().find( "option" ).removeAttr( 'selected' );
						$( this ).parent().parent().prev().find( "option" ).eq( selElementIndex ).attr( 'selected', 'selected' ).trigger( "change" );
						$( selectDiv ).hide();
					}
				}
				if( $( v ).parent().get( 0 ).tagName == 'SELECT' ) { /* fisrt childs of select */
					selectDiv.appendChild( elem );
				} else {
					$( selectDiv ).children().last().append( elem );
				}
			});
			var hider = function(event) {
					event = event || window.event; /* crossbrowser event */
				if( ( event.target || event.srcElement ).className != 'archy-optgroup-h1' && /* crossbrowser event.target */
				( event.target || event.srcElement ).className != 'archy-optgroup' && 
				( event.target || event.srcElement ).className != 'archy-select-block' ) {
					if( clickCleaner ) {

						/* hide select div */

						$( selectDiv ).fadeOut( 200 );
						$( this ).off( 'click', hider );

						/* reset all selected elements */

						$( selectDiv ).trigger( 'mousemove' );
					}
					clickCleaner = true;
					event.preventDefault();
				}
			}
			var clickCleaner;
			$( fakeSelect ).on( 'mousedown', function() {
				/* show/hide scripts */
				clickCleaner = false;
				$( selectDiv ).fadeIn( 200 );
				$( 'html' ).on( 'click', hider);

				/* set to choosed item class 'selected' */

				$( this ).find( '.archy-select-block .' + $( this ).children( 'h1' ).attr( 'class' ) ).addClass( 'selected' );
			});				
			fakeSelect.appendChild( selectDiv );
			$( val ).after( fakeSelect );
			$( selectDiv ).hide();
		});	


		/* *** *** Create fancy radio *** *** */
		if( $( this ).find( 'input[type="radio"]' ) ) {
			var fakeContainer = $( '<span class="archy-fake-radio-container" />' ),
			fakeRadio = $( '<span class="archy-fake-radio" />' ),
			contRadioItem = $( '<div class="archy-radio-item-container" />' );
			$( this ).each(function(k, v){
				$( v ).find( '.radio' ).removeClass( 'radio' ).addClass( 'archy-radio-custom' );

				$( v ).find( 'input[type="radio"]' ).wrap( fakeContainer );
				var label = $( v ).find( '.archy-fake-radio-container' ).next().detach(); /* remove all labels and save in variable */
				$( v ).find( '.archy-fake-radio-container' ).wrap( contRadioItem );
				$( v ).find( '.archy-radio-item-container' ).each( function() { /* separate label for each radio */
					var cont = this;
					$( label ).each(function() {
						if( $( this ).attr( 'for' ) ==  $( cont ).find( 'input' ).attr( 'id' ) ) {
							$( cont ).append( $( this ) );
						}
					});
				});
				$( v ).find( '.archy-fake-radio-container' ).append( fakeRadio );
				/* if radio was selected */
				$( v ).find( 'input[type=radio]:checked' ).next().addClass( 'selected' );
				/* if radio is disabled */
				$( v ).find( 'input[type=radio]' ).each( function() {
					if( $( this ).attr( 'disabled' ) ) {
						$( this ).next().addClass( 'disabled' );
					}
				});
				/* events handlers */
				$( v ).find( 'input[type="radio"]' ).on( 'click', function(){
					$( v ).find( 'input[name="' + $( this ).attr( 'name' ) + '"]' ).next().removeClass( 'selected' );
					$( this ).parent().find( '.archy-fake-radio' ).addClass( 'selected' );
				});
				$( v ).find( '.archy-fake-radio' ).on( 'click', function(){
					if(! $( this ).prev().attr( 'disabled' ) ) {
						$( this ).prev().trigger( 'click' );
					}
				});
			});
		}


		/* *** *** Create fancy checkboxes *** *** */
		if( $( this ).find( 'input[type="checkbox"]' ) ) {
			var fakeContainerCheck = $( '<span class="archy-fake-checkbox-container" />' ),
			fakeCheckbox = $( '<span class="archy-fake-checkbox" />' ),
			contCheckboxItem = $( '<div class="archy-checkbox-item-container" />' );
			$( this ).each(function(k, v){
				$( v ).find( '.checkbox' ).removeClass( 'checkbox' ).addClass( 'archy-checkbox-custom' );
				$( v ).find( 'input[type="checkbox"]' ).wrap( fakeContainerCheck );
				$( v ).find( '.archy-fake-checkbox-container' ).wrap( contCheckboxItem );
				$( v ).find( '.archy-checkbox-item-container' ).each( function() { /* separate label for each checkbox */
					var cont = this;
					$( cont ).next().each(function() {
						if( $( this ).attr( 'for' ) ==  $( cont ).find( 'input' ).attr( 'id' ) ) {
							$( cont ).append( $( this ) );
						}
					});
				});
				$( v ).find( '.archy-fake-checkbox-container' ).append( fakeCheckbox );
				/* if checkbox was selected */
				$( v ).find( 'input[type=checkbox]:checked' ).next().addClass( 'selected' );
				/* if checkbox is disabled */
				$( v ).find( 'input[type=checkbox]' ).each( function() {
					if( $( this ).attr( 'disabled' ) ) {
						$( this ).next().addClass( 'disabled' );
					}
				});
				/* events handlers */
				$( v ).find( 'input[type="checkbox"]' ).on( 'click', function(){
					var fCh = $( this ).parent().find( '.archy-fake-checkbox' );
					if( fCh.hasClass( 'selected' ) ) {
						fCh.removeClass( 'selected' );
					} else {
						fCh.addClass( 'selected' );
					}
				});
				$( v ).find( '.archy-fake-checkbox' ).on( 'click', function(){
					if(! $( this ).prev().attr( 'disabled' ) ) {
						$( this ).prev().trigger( 'click' );
					}
				});
			});
		}


		/* *** *** Create upload file instrument *** *** */
		if( $( this ).find( 'input[type="file"]' ) ) {
			$( this ).find( 'input[type="file"]' ).each(function() {
				/* create fake archy-upload-file instument */
				var th = this;
				$( th ).hide();
				$( th ).after( '<div class="archy-upload-file" name="' + $( th ).attr( 'name' ) + '">\
					<div class="archy-upload-file-input" />\
					<div class="archy-upload-file-status" /></div>' );
				var inp = $( th ).next().find( '.archy-upload-file-input' );
				var st = $( th ).next().find( '.archy-upload-file-status' );
				$( inp ).text( 'Choose file...' );
				$( st ).text( $( th ).val() == '' ? 'File is not selected.' : $( th ).val() );

				$( th ).on( 'change', function() {
					var t = this;
					/* contain text of file path to fake archy-upload-file intrument */
					$( st ).text( $( this ).val() == '' ? 'File is not selected.' : function(){
						var str = $( t ).val().split( '\\' ).pop();
						if( str.length > 26 ) {
							return str.substring(0, 15) + '...' + str.substring(str.length-8, str.length);
						} else {
							return str;
						}
					});
				});
				$( inp.parent() ).on( 'mousedown', function() {
					$( th ).trigger( 'click' );
				});
			});
		}


		/* *** *** Create clear button *** *** */
		$( this ).find( 'input[type="reset"]' ).click( function() {
			var forms = $( this ).parents( 'form' ).first();
			forms.find( '.archy-select-block' ).find( '.archy-option.index-0' ).click();
			forms.find( '.archy-fake-radio, .archy-fake-checkbox' ).removeClass( 'selected' );
			$( forms )[0].reset();
			forms.find( 'input[type="file"]' ).change();

			/* Clear original selects. */
			$( 'select' ).each(function() {
				/* set path */
				var clear_select = $( this ).find( "option:first" );
				/* clear active opt */
				$( this ).find( "option" ).removeAttr( 'selected' );
				$( clear_select ).attr( 'selected', 'selected' );
			});
			/* Clear custom selects. */
			$( '.archy-select' ).each(function() {
				/* clear active opt */
				$( this ).find( ".archy-select-block" ).find( ".archy-option" ).removeAttr( "selected" );
				$( this ).find( "h1:first" ).text( $( this ).prev().find( "option:first" ).text() );
			});
			e.preventDefault;
		});	


		/* *** *** archy-slider *** *** */
		if( $( this ).find( '.archy-slider' ) ) {
			var isSlideTime = true; // don't allow to change the slides before the animation is complete
			var slide = 0;
			var slChd = $( '.archy-slider' ).children();
			// run the currently selected effect
			var callbackSlide = function (elem) {
				slide = elem;
			}
				function slideTo( leftRight ) {
					isSlideTime = false;
					var el;
					if( leftRight == 'left') {
						el = slide+1;
						if( el >= slChd.length ) {
							el = 0;
						}
					} else {
						el = slide-1;
						if( el < 0 ) {
							el = slChd.length-1;
						}
					}
					// show next/prev slide
					slChd.eq( el ).show();

					// run the effect
					slChd.eq( slide ).effect( 'drop',
						{
							direction: leftRight == 'left' ? 'right' : 'left'
						},
						500,
						callbackSlide( el )
					);

					setTimeout(function() {
						isSlideTime = true;
					}, 600);
				};
			// set effect from select menu value
			$( '.archy-left-slider-handler' ).click(function() {
				if( isSlideTime ) {
					slideTo( 'left' );
				}
				return false;
			});
			$( '.archy-right-slider-handler' ).click(function() {
				if( isSlideTime ) {
					slideTo( 'right' );
				}
				return false;
			});
		}


		/* *** *** main navigation *** *** */
		var notVar, mainItems;
		/* if menu in admin is not checked */
		if( $( 'div.menu' ).length > 0 ) {
			notVar = '.children li';
			mainItems = '.menu > ul > li';
		} else {
			notVar = '.sub-menu li';
			mainItems = '.menu > li';
		}
		var timers = { };
		/* Main navigation items */
		var mni = $( 'nav ul' ).children().not( notVar );
		mni.each(function(k) {
			if( $( this ).children( 'ul' ).length > 0 ) {
				/* creating up arrow for main items of menu, which haven some items */
				var upArrow = document.createElement( 'div' );
				upArrow.className = 'up-arrow';
				$( this ).append( upArrow ); /* add arrow to every main item of menu */

				$( this ).hover(function() {
					$( this ).children( 'ul, div' ).show();
					mni.not( this ).find( 'ul, div' ).hide();
				});
				$( this ).mouseenter(function() {
					clearTimeout( timers[ 'header-timer' + k ] );
					delete timers[ 'header-timer' + k ];
				});
				$( this ).mouseleave(function() {
					var thisDD = $( this ).find( 'ul, div' );
					timers[ 'header-timer' + k ] = setTimeout(function() {
						$( thisDD ).hide();
					}, 600);
				});
			}
		});
		// 15 - it's $( '.archy-site-header.archy-clearfix' ).css( 'padding-bottom', '15px' );
		// correct height of header if custom header is enabled
		if( $( '.archy-custom-header img' ).length > 0 ) {
			if( $( '.archy-custom-header img' ).attr( 'height' ) <= $( '.archy-site-header-container' ).outerHeight() + 15 ) {
				$( '.archy-site-header' ).height( $( '.archy-site-header-container' ).outerHeight() + 15 );
			}
		} else {
			$( '.archy-site-header' ).height( $( '.archy-site-header-container' ).outerHeight() + 15 );
		}
		/* all items without main */
		$( '.archy-main-navigation ul li' ).not( mni ).each(function() {
			$( this ).hover(function() {
				$( this ).children().not( 'a' ).show();
			});
			$( this ).mouseenter(function() {

				if( $( this ).offset().left + 2 * $( this ).outerWidth() > $( window ).width() ) {
					$( this ).find( 'ul' ).css( 'left', '-100.3%' ); /* 0.3% - border-shadow */
				} else if ( $( this ).offset().left - $( this ).outerWidth() < 0 ) {
					$( this ).find( 'ul' ).css( 'left', '100.3%' ); /* 0.3% - border-shadow */
				}
				$( this ).parent( 'ul' ).find( 'ul' ).not( $( this ).find( 'ul' ) ).hide();
			});
			$( this ).mouseleave(function(e) {
				e = event || window.event;
				var goingTo = e.relatedTarget || e.toElement;

				var thisLi = this;
				var isLiOnList = function() {
					var isPar = false;
					$( thisLi ).parents( mainItems ).find( 'li' ).each(function() {
						if( $( this ).css( 'display' ) == 'block' && $( goingTo ).get( 0 ) == $( this ).get( 0 ) ) {
							isPar = true;
							return false;
						}
					});
					return isPar;
				}
				if( isLiOnList() ) {
					$( this ).find( 'ul' ).hide();
				} else {
					$( this ).children( 'li' ).show();
				}
			});
		}); /* end main navigation */
	});

} )( jQuery );