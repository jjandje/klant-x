<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RecipeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RecipeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RecipeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Recipe');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/recipe');
        $this->crud->setEntityNameStrings('recept', 'recepten');
    }

    protected function setupListOperation()
    {
	    $this->crud->addColumn([
		    'name'      => 'title',
		    'label'     => 'Titel',
		    'type'      => 'text',
	    ]);
	    $this->crud->addColumn([
		    'name'      => 'image', // The db column name
		    'label'     => 'Afbeelding', // Table column heading
		    'type'      => 'image',
		    'prefix'    => 'uploads/',
		    'height'    => '70px',
		    'width'     => '70px',
            'default'    => '',
	    ])->beforeColumn('title');
	    $this->crud->addColumn([
		    'name'          => 'categories',
		    'label'         => 'Categorie',
		    'type'          => 'model_function',
		    'function_name' => 'getCategoryNames',
	    ]);
	    $this->crud->addColumn([
	    	'name'          => 'dishes',
		    'label'         => 'Gerechtgang(en)',
		    'type'          => 'model_function',
		    'function_name' => 'getDishNames',
	    ]);
//	    $this->crud->addColumn([
//		    'name'          => 'goals',
//		    'label'         => 'Gelinkt doel',
//		    'type'          => 'model_function',
//		    'function_name' => 'getGoalNames',
//	    ]);
	    $this->crud->addColumn([
	    	'name'          => 'author',
		    'label'         => 'Auteur',
		    'type'          => 'model_function',
		    'function_name' => 'getAuthorName',
	    ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(RecipeRequest::class);

	    $this->crud->addField([
		    'name'      => 'title',
		    'label'     => 'Titel',
		    'type'      => 'text',
	    ]);
	    $this->crud->addField([
	    	'name'      => 'user_id',
		    'type'      => 'hidden',
		    'value'     => backpack_user()->id,
	    ]);
	    $this->crud->addField([
		    'name'      => 'image',
		    'label'     => 'Afbeelding',
		    'type'      => 'image',
		    'upload'    => true,
		    'crop'      => true,
		    'ratio'     => '2',
		    'disk'      => 'uploads',
		    'prefix'    => 'uploads/',
            'default'    => '',
		    'mime_types'    => ['image'],
	    ])->afterField('title');

	    $this->crud->addField([
		    'name'      => 'content',
		    'label'     => 'Content',
		    'type'      => 'wysiwyg',
	    ]);
	    $this->crud->addField([
	    	'name'      => 'preparation',
		    'label'     => 'Bereiding',
		    'type'      => 'wysiwyg',
	    ]);
	    $this->crud->addField([
	    	'name'              => 'ingredients',
		    'label'             => 'Ingrediënten',
		    'type'              => 'table',
		    'entity_singular'   => 'ingrediënt',
		    'columns'           => [
		    	'name'          => 'Naam',
		    ],
	    ]);
	    $this->crud->addField([
	    	'label'     => 'Gerechtgang(en)',
		    'type'      => 'select2_multiple',
		    'name'      => 'dishes',
		    'entity'    => 'dishes',
		    'attribute' => 'title',
		    'model'     => 'App\Models\Dish',
		    'pivot'     => true,
		    'hint'      => '<small>Voeg een of meerdere receptgangen toe zodat dit recept gemakkelijk terug gevonden kan worden.</small>',
	    ]);
//	    $this->crud->addField([
//		    'label'     => 'Doelen',
//		    'type'      => 'select2_multiple',
//		    'name'      => 'goals',
//		    'entity'    => 'goals',
//		    'attribute' => 'title',
//		    'model'     => 'App\Models\Goal',
//		    'pivot'     => true,
//		    'hint'      => '<small>Het is mogelijk om later tijdens het aanmaken van een doel, dit recept te koppelen. Indien het doel al bestaat kun je deze hier koppelen.</small>',
//	    ]);
	    $this->crud->addField([
		    'label'     => 'Categorie',
		    'type'      => 'select2_multiple',
		    'name'      => 'categories',
		    'entity'    => 'categories',
		    'attribute' => 'title',
		    'model'     => 'App\Models\Category',
		    'pivot'     => true,
		    'hint'      => '<small>Voeg een of meerdere categorieën toe zodat dit recept gemakkelijk terug gevonden kan worden.</small>',
	    ]);
    }

    protected function setupUpdateOperation()
    {
	    $this->setupCreateOperation();
	    $this->crud->removeField('image');
	    $this->crud->addField([
		    'name'      => 'image',
		    'label'     => 'Afbeelding',
		    'type'      => 'image',
		    'upload'    => true,
            'crop'      => true,
            'ratio'     => '2',
		    'prefix'    => 'uploads/',
            'default'    => '',
	    ])->afterField('title');
    }
}
