@if ($crud->hasAccess('employees'))
    <a href="{{ url($crud->route.'/'.$entry->getKey().'/employees') }} " class="btn btn-xs btn-link"><i class="fa fa-group"></i> Medewerkers</a>
@endif
