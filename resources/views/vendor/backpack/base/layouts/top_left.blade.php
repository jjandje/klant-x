<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" dir="{{ config('backpack.base.html_direction') }}">

<head>
    @include(backpack_view('inc.head'))
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-MVK7TXQ');</script>
    <!-- End Google Tag Manager -->

</head>

<body class="{{ config('backpack.base.body_class') }}">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MVK7TXQ"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

@include(backpack_view('inc.main_header'))

    <div class="app-body">

        @include(backpack_view('inc.sidebar'))

        <main class="main pt-2 pb-5">
            <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
                <span class="navbar-toggler-icon"></span>
            </button>

            @includeWhen(isset($breadcrumbs), backpack_view('inc.breadcrumbs'))

            @yield('header')

            <div class="{{ strpos($__env->yieldContent('header'), 'container-fluid') ? 'container-fluid' : 'container' }} animated fadeIn">

                @if (isset($widgets['before_content']))
                    @include(backpack_view('inc.widgets'), [ 'widgets' => $widgets['before_content'] ])
                @endif

                @yield('content')

                @if (isset($widgets['after_content']))
                    @include(backpack_view('inc.widgets'), [ 'widgets' => $widgets['after_content'] ])
                @endif

            </div>

        </main>

    </div><!-- ./app-body -->

<footer class="{{ config('backpack.base.footer_class') }}">
    @include(backpack_view('inc.footer'))
</footer>

@yield('before_scripts')
@stack('before_scripts')

@include(backpack_view('inc.scripts'))

@yield('after_scripts')
@stack('after_scripts')
</body>
</html>
