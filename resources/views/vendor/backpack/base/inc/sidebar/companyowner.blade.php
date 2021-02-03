<li class="nav-title">Mijn bedrijf</li>
<li class="nav-item nav-dropdown">
	<a href="#" class="nav-link nav-dropdown-toggle"><i class="nav-icon fa fa-building"></i> Mijn bedrijf</a>
	<ul class="nav-dropdown-items">
		@can('company')
		<li class='nav-item'><a class='nav-link' href='{{ route('company.show', ['id' => backpack_user()->companies()->first()->id]) }}'><i class='nav-icon fa fa-info'></i> <span>Bedrijfsinformatie</span></a></li>
		@endcan
		@can('company-employees')
		<li class='nav-item'><a class='nav-link' href='{{ route('employees.index', ['company_id' => backpack_user()->companies()->first()->id]) }}'><i class='nav-icon fa fa-users'></i> <span>Medewerkers</span></a></li>
		@endcan
	</ul>
</li>
