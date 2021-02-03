@if (backpack_auth()->check())
    <div class="{{ config('backpack.base.sidebar_class') }}">
        <a class="navbar-brand" href="{{ url(config('backpack.base.home_link')) }}">
            <img class="navbar-brand__logo" src="{{ asset(mix('images/healthyby-logo.svg')) }}" alt="Healtyby logo">
            @if(!empty(backpack_user()->company) && !empty(backpack_user()->company->logo) && !backpack_user()->hasAnyRole(['Webmaster', 'Admin', 'Coach']))
                <img src="{{ asset('uploads/'.backpack_user()->company->logo) }}" alt="{{ backpack_user()->company->name }}" class="navbar-brand__company-logo">
            @endif
        </a>

        <nav class="sidebar-nav overflow-hidden">
            <ul class="nav">
                @include(backpack_view('inc.sidebar_content'))
            </ul>
        </nav>
    </div>
@endif

@push('before_scripts')
    <script type="text/javascript">
        /* Recover sidebar state */
        if ( Boolean( sessionStorage.getItem( 'sidebar-collapsed' ) ) ) {
            var body = document.getElementsByTagName( 'body' )[0];
            body.className = body.className.replace( 'sidebar-lg-show', '' );
        }

        /* Store sidebar state */
        var navbarToggler = document.getElementsByClassName( "navbar-toggler" );
        for ( var i = 0; i < navbarToggler.length; i++ ) {
            navbarToggler[i].addEventListener( 'click', function ( event ) {
                event.preventDefault();
                if ( Boolean( sessionStorage.getItem( 'sidebar-collapsed' ) ) ) {
                    sessionStorage.setItem( 'sidebar-collapsed', '' );
                } else {
                    sessionStorage.setItem( 'sidebar-collapsed', '1' );
                }
            } );
        }
    </script>
@endpush

@push('after_scripts')
    <script>
        // Set active state on menu element
        var full_url = "{{ Request::fullUrl() }}";
        var $navLinks = $( ".sidebar-nav li a" );

        // First look for an exact match including the search string
        var $curentPageLink = $navLinks.filter(
            function () {
                return $( this ).attr( 'href' ) === full_url;
            }
        );

        // If not found, look for the link that starts with the url
        if ( !$curentPageLink.length > 0 ) {
            $curentPageLink = $navLinks.filter( function () {
                if ( $( this ).attr( 'href' ).startsWith( full_url ) ) {
                    return true;
                }

                if ( full_url.startsWith( $( this ).attr( 'href' ) ) ) {
                    return true;
                }

                return false;
            } );
        }

        // for the found links that can be considered current, make sure
        // - the parent item is open
        $curentPageLink.parents( 'li' ).addClass( 'open' );
        // - the actual element is active
        $curentPageLink.each( function () {
            $( this ).addClass( 'active' );
        } );
    </script>
@endpush
