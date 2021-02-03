<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CompanyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CompanyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CompanyCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation { show as traitShow; }

	public function __construct(  ) {
		$this->middleware(['isusercompany', 'iscompanyowner']);
		parent::__construct();
	}

    public function setup()
    {
        $this->crud->setModel('App\Models\Company');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/company');
        $this->crud->setEntityNameStrings('company', 'companies');
        $this->crud->allowAccess('employees');
        $this->crud->addButtonFromView('line', 'showEmployees', 'show_employees', 'beginning');
	    if(!backpack_user()->hasAnyRole(['Webmaster', 'Admin'])) {
		    $this->crud->denyAccess('delete');
		    $this->crud->removeButton('delete');
	    }
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
	    $this->crud->removeColumn('logo');
	    $this->crud->addColumn([
			'name'      => 'logo', // The db column name
			'label'     => 'image', // Table column heading
			'type'      => 'image',
			'prefix'    => 'uploads/',
			'height'    => '70px',
			'width'     => '70px',
	    ]);
	    $this->crud->addColumn([
	    	'name'      => 'users',
		    'label'     => 'Medewerkers',
		    'type'      => 'model_function',
			'function_name' => 'getUsersCount',
	    ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(CompanyRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
        $this->crud->removeField('logo');
	    $this->crud->addField([
		    'name'          => 'logo',
		    'label'         => 'Logo',
		    'type'          => 'upload',
		    'upload'        => true,
		    'disk'          => 'uploads',
		    'prefix'        => 'uploads/',
		    'crop'          => true,
		    'aspect_ratio'  => 2,
	    ]);
    }

    protected function setupUpdateOperation()
    {
	    $this->crud->setFromDb();
	    $this->crud->removeField('active');
	    $this->crud->removeField('logo');
	    $this->crud->addField([
		    'name'          => 'logo',
		    'label'         => 'Logo',
		    'type'          => 'image',
		    'upload'        => true,
		    'prefix'        => 'uploads/',
		    'crop'          => true,
		    'aspect_ratio'  => 2,
	    ]);
    }

	protected function setupShowOperation(  ) {
		$this->crud->set('show.setFromDb', false);
		$this->crud->addColumn([
			'name'      => 'logo',
			'label'     => 'Logo',
			'type'      => 'image',
//			'disk'      => 'uploads',
			'prefix'    => 'uploads/',
		]);
		$this->crud->addColumn([
			'name'      => 'name',
			'label'     => 'Naam',
			'type'      => 'text',
		]);

    }
}
