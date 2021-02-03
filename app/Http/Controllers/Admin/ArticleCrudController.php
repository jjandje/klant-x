<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\BackpackUser;
use App\Models\Goal;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ArticleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ArticleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Article');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/blog');
        $this->crud->setEntityNameStrings('blog', 'blogs');
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
		    'name'          => 'goals',
		    'label'         => 'Gelinkt doel',
		    'type'          => 'model_function',
		    'function_name' => 'getGoalNames',
	    ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ArticleRequest::class);


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
	    	'name'      => 'user_id',
		    'type'      => 'hidden',
		    'value'     => backpack_user()->id,
	    ]);
	    $this->crud->addField([
		    'label'     => 'Doelen',
		    'type'      => 'select2_multiple',
		    'name'      => 'goals',
		    'entity'    => 'goals',
		    'attribute' => 'title',
		    'model'     => 'App\Models\Goal',
		    'pivot'     => true,
		    'hint'      => '<small>Het is mogelijk om later tijdens het aanmaken van een doel, dit recept te koppelen. Indien het doel al bestaat kun je deze hier koppelen.</small>',
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

	public function update(  ) {

		$request = $this->crud->validateRequest();

    	$article = Article::findOrFail($this->crud->request->request->get('id'));
    	if($article) {
    		$article->title = $this->crud->request->request->get('title');
    		$article->image = $this->crud->request->request->get('image');
    		$article->content = $this->crud->request->request->get('content');
    		if($this->crud->request->request->get('user_id')) {
    			$article->user_id = $this->crud->request->request->get('user_id');
		    }
    		$article->goals()->sync($this->crud->request->request->get('goals'));
    		/*if($this->crud->request->request->get('goal_id')) {
    			$article->goal_id = $this->crud->request->request->get('goal_id');
		    }*/
    		$article->save();
	    }
		return redirect()->route('blog.index');
    }
}
