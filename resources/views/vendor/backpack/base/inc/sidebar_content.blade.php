<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
@if(!empty(backpack_user()->userInfo) && backpack_user()->active == 1))
    {{--@can('dashboard')--}}
        {{--<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard nav-icon"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>--}}
    {{--@endcan--}}

    @can('profile')
        @include(backpack_view('inc.sidebar.user'))
    @endcan

    @can('clients')
        <li class="nav-item">
            <a href="{{ route('coach.clients') }}" class="nav-link">
                <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="users-class" class="nav-icon svg-inline--fa fa-users-class fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M544 224c-44.2 0-80 35.8-80 80s35.8 80 80 80 80-35.8 80-80-35.8-80-80-80zm0 128c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm-304-48c0 44.2 35.8 80 80 80s80-35.8 80-80-35.8-80-80-80-80 35.8-80 80zm128 0c0 26.5-21.5 48-48 48s-48-21.5-48-48 21.5-48 48-48 48 21.5 48 48zM96 384c44.2 0 80-35.8 80-80s-35.8-80-80-80-80 35.8-80 80 35.8 80 80 80zm0-128c26.5 0 48 21.5 48 48s-21.5 48-48 48-48-21.5-48-48 21.5-48 48-48zm468 160h-40c-41.9 0-76 35.9-76 80 0 8.8 7.2 16 16 16s16-7.2 16-16c0-26.5 19.8-48 44-48h40c24.2 0 44 21.5 44 48 0 8.8 7.2 16 16 16s16-7.2 16-16c0-44.1-34.1-80-76-80zm-448 0H76c-41.9 0-76 35.9-76 80 0 8.8 7.2 16 16 16s16-7.2 16-16c0-26.5 19.8-48 44-48h40c24.2 0 44 21.5 44 48 0 8.8 7.2 16 16 16s16-7.2 16-16c0-44.1-34.1-80-76-80zm224 0h-40c-41.9 0-76 35.9-76 80 0 8.8 7.2 16 16 16s16-7.2 16-16c0-26.5 19.8-48 44-48h40c24.2 0 44 21.5 44 48 0 8.8 7.2 16 16 16s16-7.2 16-16c0-44.1-34.1-80-76-80zM64 48c0-8.83 7.19-16 16-16h480c8.81 0 16 7.17 16 16v149.22c11.51 3.46 22.37 8.36 32 15.11V48c0-26.47-21.53-48-48-48H80C53.53 0 32 21.53 32 48v164.33c9.63-6.75 20.49-11.64 32-15.11V48z"></path></svg>
                <span>{{ __('coach.clients') }}</span>
            </a>
        </li>
    @endcan
    @can('manage-content')
        @include(backpack_view('inc.sidebar.admin-content'))
    @endcan
    @can('manage-users')
        @include(backpack_view('inc.sidebar.admin-users'))
    @endcan
    @can('applications')
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('application') }}'><i class='nav-icon fa fa-question'></i> <span>Aanvragen</span></a></li>
    @endcan
    @can('logs')
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('log') }}'><i class='nav-icon fa fa-terminal'></i> <span>Logs</span></a></li>
    @endcan

    @can('manage-company')
        @include(backpack_view('inc.sidebar.companyowner'))
    @endcan

    @can('settings')
    <li class="nav-title">Instellingen</li>
    <li class="nav-item">
        <a href="{{ route('backpack.account.password') }}" class="nav-link">
            <i class="nav-icon fa fa-cog"></i>
            <span>Instellingen</span>
        </a>
    </li>
    @endcan
    <li class="nav-item">
        <a class="nav-link" href="{{ backpack_url('logout') }}">
            <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="sign-out-alt" class="nav-icon svg-inline--fa fa-sign-out-alt fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M160 217.1c0-8.8 7.2-16 16-16h144v-93.9c0-7.1 8.6-10.7 13.6-5.7l141.6 143.1c6.3 6.3 6.3 16.4 0 22.7L333.6 410.4c-5 5-13.6 1.5-13.6-5.7v-93.9H176c-8.8 0-16-7.2-16-16v-77.7m-32 0v77.7c0 26.5 21.5 48 48 48h112v61.9c0 35.5 43 53.5 68.2 28.3l141.7-143c18.8-18.8 18.8-49.2 0-68L356.2 78.9c-25.1-25.1-68.2-7.3-68.2 28.3v61.9H176c-26.5 0-48 21.6-48 48zM0 112v288c0 26.5 21.5 48 48 48h132c6.6 0 12-5.4 12-12v-8c0-6.6-5.4-12-12-12H48c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16h132c6.6 0 12-5.4 12-12v-8c0-6.6-5.4-12-12-12H48C21.5 64 0 85.5 0 112z"></path></svg>
            <span>{{ trans('backpack::base.logout') }}</span>
        </a>
    </li>
@endif
