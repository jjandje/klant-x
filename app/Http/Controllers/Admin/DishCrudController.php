<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DishRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DishCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DishCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Dish');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/dish');
        $this->crud->setEntityNameStrings('gerechtgang', 'gerechtgangen');
    }

    protected function setupListOperation()
    {
	    $this->crud->addColumns([
		    [
			    'name'  => 'title',
			    'label' => 'Titel',
			    'type'  => 'text',
		    ],
		    [
			    'name'  => 'slug',
			    'label' => 'Slug',
			    'type'  => 'text',
		    ],
	    ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(DishRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
