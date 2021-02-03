<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GoalRequest;
use App\Models\Article;
use App\Models\Recipe;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class GoalCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class GoalCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Goal');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/goal');
        $this->crud->setEntityNameStrings('doel', 'doelen');
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
	    ])->beforeColumn('title');
	    $this->crud->addColumn([
	    	'name'          => 'duration',
		    'label'         => 'Duur',
		    'type'          => 'number',
		    'suffix'        => ' weken',
	    ]);
	    $this->crud->addColumn([
	    	'name'          => 'articles',
		    'label'         => 'Gelinkte artikelen',
		    'type'          => 'model_function',
		    'function_name' => 'getArticleNames',
	    ]);
	    $this->crud->addColumn([
		    'name'          => 'recipes',
		    'label'         => 'Gelinkte recepten',
		    'type'          => 'model_function',
		    'function_name' => 'getRecipeNames',
	    ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(GoalRequest::class);

	    $this->crud->addField([
	    	'name'      => 'title',
		    'label'     => 'Titel',
		    'type'      => 'text',
	    ]);
	    $this->crud->addField([
		    'name'      => 'image',
		    'label'     => 'Afbeelding',
		    'type'      => 'image',
		    'upload'    => true,
		    'disk'      => 'uploads',
		    'prefix'    => 'uploads/',
		    'mime_types'    => ['image'],
	    ])->afterField('title');
	    $this->crud->addField([
	    	'name'      => 'workbook',
		    'label'     => 'Werkboek',
		    'type'      => 'upload',
		    'upload'    => true,
		    'disk'      => 'uploads',
		    'prefix'    => 'uploads/',
	    ]);
	    $this->crud->addField([
	    	'name'      => 'content',
		    'label'     => 'Content',
		    'type'      => 'wysiwyg',
	    ]);
	    $this->crud->addField([
	    	'name'      => 'duration',
		    'label'     => 'Duur van doel',
		    'type'      => 'number',
		    'suffix'    => 'weken',
	    ]);
	    $this->crud->addField([
	    	'label'     => 'Blogs',
		    'type'      => 'select2_multiple',
		    'name'      => 'articles',
		    'entity'    => 'articles',
		    'attribute' => 'title',
		    'pivot'     => true,
	    ]);
	    $this->crud->addField([
	    	'label'     => 'Recepten',
		    'type'      => 'select2_multiple',
		    'name'      => 'recipes',
		    'entity'    => 'recipes',
		    'attribute' => 'title',
		    'pivot'     => true,
	    ]);
    }

    protected function setupUpdateOperation()
    {
	    $this->crud->setValidation( GoalRequest::class );
        $this->setupCreateOperation();
	    $this->crud->removeField('image');
	    $this->crud->addField([
		    'name'      => 'image',
		    'label'     => 'Afbeelding',
		    'type'      => 'image',
		    'upload'    => true,
		    'prefix'    => 'uploads/',
	    ])->afterField('title');
	    $this->crud->removeField('articles');
	    $this->crud->removeField('recipes');
	    $this->crud->addField([
		    'label'     => 'Blogs',
		    'type'      => 'select2_multiple',
		    'name'      => 'articles',
		    'entity'    => 'articles',
		    'attribute' => 'title',
		    'value'     => $this->crud->getCurrentEntry()->articles,
		    'pivot'     => true,
	    ]);
	    $this->crud->addField([
		    'label'     => 'Recepten',
		    'type'      => 'select2_multiple',
		    'name'      => 'recipes',
		    'entity'    => 'recipes',
		    'attribute' => 'title',
		    'value'     => $this->crud->getCurrentEntry()->recipes,
		    'pivot'     => true,
	    ]);
    }

	public function update(  ) {

		$request = $this->crud->validateRequest();

    	$goal = $this->crud->getCurrentEntry();
    	$goal->title = $this->crud->request->request->get('title');
    	$goal->image = $this->crud->request->request->get('image');
    	$goal->content = $this->crud->request->request->get('content');
    	$goal->workbook = $this->crud->request->request->get('workbook');
    	$goal->duration = $this->crud->request->request->get('duration');

		$articles = $this->crud->request->request->get('articles');
		$recipes = $this->crud->request->request->get('recipes');

		$goal->articles()->sync($articles);
		$goal->recipes()->sync($recipes);

		$goal->save();

		return redirect()->route('goal.index');
    }
}
