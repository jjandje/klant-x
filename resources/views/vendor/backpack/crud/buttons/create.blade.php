@if ($crud->hasAccess('create'))
    <a href="{{ url($crud->route.'/create') }}" class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> {{ ucfirst($crud->entity_name) }} {{ strtolower(trans('backpack::crud.add')) }}</span></a>
@endif
