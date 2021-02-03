<li class="nav-item nav-dropdown">
    <a href="#" class="nav-link nav-dropdown-toggle"><i class="nav-icon fa fa-group"></i> Gebruikersbeheer</a>
    <ul class="nav-dropdown-items">
        @can('companies')
            <li class="nav-item"><a class='nav-link' href='{{ backpack_url('company') }}'><i class='nav-icon fa fa-building'></i> <span>Bedrijven</span></a></li>
        @endcan
        @can('users')
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon fa fa-user"></i> <span>Gebruikers</span></a></li>
        @endcan
        @can('roles')
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon fa fa-group"></i> <span>Rollen</span></a></li>
        @endcan
        @can('permissions')
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon fa fa-key"></i> <span>Permissions</span></a></li>
        @endcan
    </ul>
</li>
