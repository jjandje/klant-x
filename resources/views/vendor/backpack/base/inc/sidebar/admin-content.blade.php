<li class="nav-title">Beheer</li>
<li class="nav-item nav-dropdown">
    <a href="#" class="nav-link nav-dropdown-toggle"><i class="nav-icon fa fa-key"></i> Content beheer</a>
    <ul class="nav-dropdown-items">
        @can('pages')
            <li class='nav-item'>
                <a class='nav-link' href='{{ backpack_url('page') }}'>
                    <i class='nav-icon fa fa-file-o'></i>
                    <span>Pagina's</span>
                </a>
            </li>
        @endcan
        @can('menu-items')
            <li class='nav-item'>
                <a class='nav-link' href="{{ backpack_url('menu-item') }}">
                    <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="bars" class="nav-icon svg-inline--fa fa-bars fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M442 114H6a6 6 0 0 1-6-6V84a6 6 0 0 1 6-6h436a6 6 0 0 1 6 6v24a6 6 0 0 1-6 6zm0 160H6a6 6 0 0 1-6-6v-24a6 6 0 0 1 6-6h436a6 6 0 0 1 6 6v24a6 6 0 0 1-6 6zm0 160H6a6 6 0 0 1-6-6v-24a6 6 0 0 1 6-6h436a6 6 0 0 1 6 6v24a6 6 0 0 1-6 6z"></path></svg>
                    <span>Menu</span>
                </a>
            </li>
        @endcan
        {{--@can('packages')--}}
        {{--<li class='nav-item'><a class='nav-link' href='{{ backpack_url('package') }}'><i class='nav-icon fa fa-archive'></i> <span>Pakketten</span></a></li>--}}
        {{--@endif--}}
        @can('goals')
            <li class='nav-item'>
                <a class='nav-link' href='{{ backpack_url('goal') }}'>
                    <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="bullseye" class="nav-icon svg-inline--fa fa-bullseye fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path fill="currentColor" d="M248 92c-90.65 0-164 73.36-164 164 0 90.65 73.36 164 164 164 90.65 0 164-73.36 164-164 0-90.65-73.36-164-164-164zm0 296c-72.79 0-132-59.21-132-132s59.21-132 132-132 132 59.21 132 132-59.21 132-132 132zm0-212c-44.11 0-80 35.89-80 80s35.89 80 80 80 80-35.89 80-80-35.89-80-80-80zm0 128c-26.47 0-48-21.53-48-48s21.53-48 48-48 48 21.53 48 48-21.53 48-48 48zm0-296C111.03 8 0 119.03 0 256s111.03 248 248 248 248-111.03 248-248S384.97 8 248 8zm0 464c-119.1 0-216-96.9-216-216S128.9 40 248 40s216 96.9 216 216-96.9 216-216 216z"></path></svg>
                    Doelen
                </a>
            </li>
        @endcan
        @can('recipes')
            <li class='nav-item'>
                <a class='nav-link' href='{{ backpack_url('recipe') }}'>
                    <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="salad" class="nav-icon svg-inline--fa fa-salad fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M495.82 288h5A110.13 110.13 0 0 0 512 240c0-33.16-14.77-62.69-37.75-83.21C459 103.33 410.38 64 352 64c-3.63 0-7.05.77-10.61 1.07C323.6 26.74 285 0 240 0s-83.6 26.74-101.39 65.07c-3.56-.3-7-1.07-10.61-1.07A128 128 0 0 0 0 192c0 38.58 17.43 72.66 44.52 96H16.18C7 288-.74 295.72.06 304.84 6.7 381.21 58.18 444.23 128 468.69V480a32.16 32.16 0 0 0 32.21 32h192.25c17.7 0 31.54-14.33 31.54-32v-11.51c69.49-24.62 121.32-87.49 127.94-163.65.8-9.12-6.94-16.84-16.12-16.84zM480 240a78.45 78.45 0 0 1-16.71 48H336.71A78.51 78.51 0 0 1 320 240a80 80 0 0 1 160 0zM32 192c0-35.13 23-104.78 128-96 27.87-63.73 65.28-64 80-64 14.18 0 52 0 80 64 35.07-2.93 76.19-1.1 106 35.35a110.79 110.79 0 0 0-26-3.35 112.12 112.12 0 0 0-112 112 110.27 110.27 0 0 0 11.09 48H256V104a8 8 0 0 0-8-8h-16a8 8 0 0 0-8 8v161.37l-111-111a8 8 0 0 0-11.31 0l-11.35 11.29a8 8 0 0 0 0 11.31l111 111H128A96.11 96.11 0 0 1 32 192zm341.79 246.34L352 445.89V480H160v-34l-21.23-7.51C85.11 419.7 45.74 374.27 34.59 320h442.82c-11.12 54.07-50.27 99.43-103.62 118.34z"></path></svg>
                    Recepten
                </a>
            </li>
        @endcan
        @can('recipe-categories')
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('category') }}'><i class='nav-icon fa fa-question'></i> Recept categorieën</a></li>
        @endcan
        @can('recipes')
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('dish') }}'><i class='nav-icon fa fa-question'></i> Gerechtgangen</a></li>
        @endcan
        @can('articles')
            <li class='nav-item'>
                <a class='nav-link' href='{{ backpack_url('blog') }}'>
                    <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="file-alt" class="nav-icon svg-inline--fa fa-file-alt fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zm-22.6 22.7c2.1 2.1 3.5 4.6 4.2 7.4H256V32.5c2.8.7 5.3 2.1 7.4 4.2l83.9 83.9zM336 480H48c-8.8 0-16-7.2-16-16V48c0-8.8 7.2-16 16-16h176v104c0 13.3 10.7 24 24 24h104v304c0 8.8-7.2 16-16 16zm-48-244v8c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12zm0 64v8c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12zm0 64v8c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12z"></path></svg>
                    Blogs
                </a>
            </li>
        @endcan
    </ul>
</li>
