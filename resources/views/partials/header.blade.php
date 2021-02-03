<header class="header">
    <div class="container">
        <div class="row">

            <div class="d-flex align-items-center col-lg-2 justify-content-between">
                <a href="/" class="header__logo">
                    <img src="{{ asset(mix('images/healthyby-logo.svg')) }}" alt="Healtyby logo">
                </a>

                <div class="header__burger-box">
                    <div class="menu-icon-container">
                        <a href="#" class="menu-icon js-menu_toggle closed">
                            <span class="menu-icon_box">
                              <span class="menu-icon_line menu-icon_line--1"></span>
                              <span class="menu-icon_line menu-icon_line--2"></span>
                              <span class="menu-icon_line menu-icon_line--3"></span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <nav class="header__menu d-flex col-lg-10 justify-content-between">
                <div class="d-flex align-items-center">
                    @php $menu = \App\Models\MenuItem::getTree(); @endphp
                    @if(!empty($menu))
                        <ul class="list-load">
                            @foreach($menu as $menu_item)
                                <li class="list_item">
                                    <a href="{{ $menu_item->url() }}">{{ $menu_item->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="d-flex align-items-center">
                    <ul class="list-load">
                        @if(backpack_user())
                            <li class="list_item">
                                <a href="{{ route('backpack.profile.show') }}">Dashboard</a>
                            </li>
                            <li class="list_item">
                                <a href="{{ route('backpack.auth.logout') }}" class="button button--primary">{{ trans('backpack::base.logout') }}</a>
                            </li>
                        @else
                            <li class="list_item">
                                <a href="{{ route('application.index') }}">Aanmelden</a>
                            </li>
                            <li class="list_item">
                                <a href="{{ route('backpack.auth.login') }}" class="button button--primary">{{ trans('backpack::base.login') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>
