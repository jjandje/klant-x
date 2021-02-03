$( document ).ready( function () {

    $( document ).on( 'click', '.js-menu_toggle.closed', function ( e ) {
        e.preventDefault();
        $( '.list_load, .list_item' ).stop();
        $( this ).removeClass( 'closed' ).addClass( 'opened' );

        $( '.header__menu' ).css( {'left': '0px'} );

        var count = $( '.list_item' ).length;
        $( '.list_load' ).slideDown( (count * .6) * 100 );
        $( '.list_item' ).each( function ( i ) {
            var thisLI = $( this );
            timeOut = 100 * i;
            setTimeout( function () {
                thisLI.css( {
                    'opacity': '1',
                    'margin-left': '0'
                } );
                $( 'html, body' ).addClass( 'fixed' );
            }, 100 * i );
        } );
    } );

    $( document ).on( 'click', '.js-menu_toggle.opened', function ( e ) {
        e.preventDefault();
        $( '.list_load, .list_item' ).stop();
        $( this ).removeClass( 'opened' ).addClass( 'closed' );

        $( '.header__menu' ).css( {'left': '-100vw'} );

        var count = $( '.list_item' ).length;
        $( '.list_item' ).css( {
            'opacity': '0',
            'margin-left': '-100vw'
        } );
        $( 'html, body' ).removeClass( 'fixed' );
        $( '.list_load' ).slideUp( 300 );
    } );

    $( document ).on( 'click', '.how-it-works-hero__progress li', function ( e ) {
        e.preventDefault();
        const tab = $( this ).find( 'a' ).attr( 'href' );

        $( '.how-it-works-hero__progress li, .how-it-works-hero__tab' ).removeClass( 'active' );
        $( this ).addClass( 'active' );
        $( tab ).addClass( 'active' );
    } );


    $( document ).on( 'click', '.button__previous, .button__next', function ( e ) {
        e.preventDefault();

        let button = $(this),
            currentListItem = $('.how-it-works-hero__progress li.active'),
            currentTab = Number($('.how-it-works-hero__tab.active').attr('id').replace('tab',''));

        console.log(currentTab);

        if(button.hasClass('button__next')) {
            $('#tab' + currentTab).removeClass('active');
            $('#tab' + Number(currentTab + 1)).addClass('active');
            currentListItem.removeClass('active');

            if(currentTab !== 4) {
                currentListItem.next().addClass('active');
            } else {
                $('#tab1').addClass('active');
                $('.how-it-works-hero__progress li:nth-child(1)').addClass('active');
            }
        } else {
            $('#tab' + currentTab).removeClass('active');
            $('#tab' + Number(currentTab - 1)).addClass('active');
            currentListItem.removeClass('active');

            if(currentTab !== 1) {
                currentListItem.prev().addClass('active');
            } else {
                $('#tab4').addClass('active');
                $('.how-it-works-hero__progress li:nth-child(4)').addClass('active');
            }
        }
    } );

    $('input[name="general-conditions"]').change(function(){
        if($(this).is(':checked')) {
            $('button:disabled').removeAttr('disabled');
        } else {
            $('button[type="submit"]').attr('disabled', 'disabled');
        }
    });
} );
