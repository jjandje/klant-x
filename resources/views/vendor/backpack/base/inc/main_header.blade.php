<header class="{{ config('backpack.base.header_class') }} d-lg-none">

  <!-- Logo -->
  <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto ml-3" type="button" data-toggle="sidebar-show">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a href="{{ url(config('backpack.base.home_link')) }}">
    <img class="app-header__logo" src="{{ asset(mix('images/healthyby-logo.svg')) }}" alt="Healtyby logo">
  </a>
  @include(backpack_view('inc.menu'))
</header>
