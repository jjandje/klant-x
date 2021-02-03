<?php

namespace App;

trait PageTemplates
{
	/*
	|--------------------------------------------------------------------------
	| Page Templates for Backpack\PageManager
	|--------------------------------------------------------------------------
	|
	| Each page template has its own method, that define what fields should show up using the Backpack\CRUD API.
	| Use snake_case for naming and PageManager will make sure it looks pretty in the create/update form
	| template dropdown.
	|
	| Any fields defined here will show up after the standard page fields:
	| - select template
	| - page name (only seen by admins)
	| - page title
	| - page slug
	*/

    private function front_page()
    {
        $this->crud->addField([
            'name' => 'meta_title',
            'label' => trans('backpack::pagemanager.meta_title'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Meta informatie',
        ]);
        $this->crud->addField([
            'name' => 'meta_description',
            'label' => trans('backpack::pagemanager.meta_description'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Meta informatie',
        ]);
        $this->crud->addField([
            'name' => 'meta_keywords',
            'type' => 'textarea',
            'label' => trans('backpack::pagemanager.meta_keywords'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Meta informatie',
        ]);
        $this->crud->addField([
            'name' => 'content',
            'label' => trans('backpack::pagemanager.content'),
            'type' => 'wysiwyg',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'tab' => 'Header',
        ]);
        $this->crud->addField([
            'name' => 'image',
            'label' => 'Afbeelding header',
            'type' => 'image',
            'crop' => 'true',
            'aspect_ratio' => 0,
            'upload' => true,
            'disk' => 'uploads',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Header',
        ]);
        $this->crud->addField([   // CustomHTML
            'name' => 'title_usp1',
            'label' => 'USP 1',
            'type' => 'text',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "USP's",
        ]);
        $this->crud->addField([   // CustomHTML
            'name' => 'title_usp2',
            'label' => 'USP 2',
            'type' => 'text',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "USP's",
        ]);
        $this->crud->addField([   // CustomHTML
            'name' => 'title_usp3',
            'label' => 'USP 3',
            'type' => 'text',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "USP's",
        ]);
        $this->crud->addField([
            'name' => 'content_text_title',
            'label' => trans('Titel'),
            'type' => 'text',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Content blok 1",
        ]);
        $this->crud->addField([
            'name' => 'content_text_block',
            'label' => trans('backpack::pagemanager.content'),
            'type' => 'wysiwyg',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Content blok 1",
        ]);
        $this->crud->addField([
            'name' => 'content_text_block_grey_title',
            'label' => trans('Titel'),
            'type' => 'text',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Content blok 2",
        ]);
        $this->crud->addField([
            'name' => 'content_text_block_grey',
            'label' => trans('backpack::pagemanager.content'),
            'type' => 'wysiwyg',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Content blok 2",
        ]);

        $this->crud->addField([
        	'name'  => 'goal_1',
	        'label' => 'Doel 1',
	        'type'  => 'select2',
	        'entity'    => 'page',
	        'attribute' => 'title',
	        'model'     => 'App\Models\Page',
	        'tab'       => 'Doelen',
	        'fake'  => true,
	        'store_in'  => 'extras',
        ]);
	    $this->crud->addField([
            'name'  => 'goal_1_title',
            'label' => 'Titel doel 1',
            'type'  => 'text',
            'placeholder'   => 'Titel doel 1',
            'fake'  => true,
            'store_in'  => 'extras',
            'tab'   => 'Doelen',
        ]);
        $this->crud->addField([
            'name'  => 'goal_1_img',
            'label' => 'Afbeelding doel 1',
            'type'  => 'image',
            'upload'    => true,
            'crop'  => true,
            'aspect_ratio'  => 2,
            'fake'  => true,
            'store_in'  => 'extras',
            'tab'   => 'Doelen',
        ]);
	    $this->crud->addField([
            'name'  => 'separator_1',
            'type'  => 'custom_html',
            'value' => '<hr>',
            'tab'   => 'Doelen',
        ]);

	    $this->crud->addField([
		    'name'  => 'goal_2',
		    'label' => 'Doel 2',
		    'type'  => 'select2',
		    'entity'    => 'page',
		    'attribute' => 'title',
		    'model'     => 'App\Models\Page',
		    'tab'       => 'Doelen',
		    'fake'  => true,
		    'store_in'  => 'extras',
	    ]);
	    $this->crud->addField([
		    'name'  => 'goal_2_title',
		    'label' => 'Titel doel 2',
		    'type'  => 'text',
		    'placeholder'   => 'Titel doel 1',
		    'fake'  => true,
		    'store_in'  => 'extras',
		    'tab'   => 'Doelen',
	    ]);
	    $this->crud->addField([
		    'name'  => 'goal_2_img',
		    'label' => 'Afbeelding doel 2',
		    'type'  => 'image',
		    'upload'    => true,
		    'crop'  => true,
		    'aspect_ratio'  => 2,
		    'fake'  => true,
		    'store_in'  => 'extras',
		    'tab'   => 'Doelen',
	    ]);
	    $this->crud->addField([
		    'name'  => 'separator_2',
		    'type'  => 'custom_html',
		    'value' => '<hr>',
		    'tab'   => 'Doelen',
	    ]);

	    $this->crud->addField([
		    'name'  => 'goal_3',
		    'label' => 'Doel 3',
		    'type'  => 'select2',
		    'entity'    => 'page',
		    'attribute' => 'title',
		    'model'     => 'App\Models\Page',
		    'tab'       => 'Doelen',
		    'fake'  => true,
		    'store_in'  => 'extras',
	    ]);
	    $this->crud->addField([
		    'name'  => 'goal_3_title',
		    'label' => 'Titel doel 3',
		    'type'  => 'text',
		    'placeholder'   => 'Titel doel 3',
		    'fake'  => true,
		    'store_in'  => 'extras',
		    'tab'   => 'Doelen',
	    ]);
	    $this->crud->addField([
		    'name'  => 'goal_3_img',
		    'label' => 'Afbeelding doel 3',
		    'type'  => 'image',
		    'upload'    => true,
		    'crop'  => true,
		    'aspect_ratio'  => 2,
		    'fake'  => true,
		    'store_in'  => 'extras',
		    'tab'   => 'Doelen',
	    ]);
	    $this->crud->addField([
		    'name'  => 'separator_3',
		    'type'  => 'custom_html',
		    'value' => '<hr>',
		    'tab'   => 'Doelen',
	    ]);

	    $this->crud->addField([
		    'name'  => 'goal_4',
		    'label' => 'Doel 4',
		    'type'  => 'select2',
		    'entity'    => 'page',
		    'attribute' => 'title',
		    'model'     => 'App\Models\Page',
		    'tab'       => 'Doelen',
		    'fake'  => true,
		    'store_in'  => 'extras',
	    ]);
	    $this->crud->addField([
		    'name'  => 'goal_4_title',
		    'label' => 'Titel doel 4',
		    'type'  => 'text',
		    'placeholder'   => 'Titel doel 4',
		    'fake'  => true,
		    'store_in'  => 'extras',
		    'tab'   => 'Doelen',
	    ]);
	    $this->crud->addField([
		    'name'  => 'goal_4_img',
		    'label' => 'Afbeelding doel 4',
		    'type'  => 'image',
		    'upload'    => true,
		    'crop'  => true,
		    'aspect_ratio'  => 2,
		    'fake'  => true,
		    'store_in'  => 'extras',
		    'tab'   => 'Doelen',
	    ]);

//        $this->crud->addField([
//        	'name'  => 'goal_1_title',
//	        'label' => 'Titel doel 1',
//	        'type'  => 'text',
//	        'placeholder'   => 'Titel doel 1',
//	        'fake'  => true,
//	        'store_in'  => 'extras',
//	        'tab'   => 'Doelen',
//        ]);
//	    $this->crud->addField([
//		    'name'  => 'goal_1_img',
//		    'label' => 'Afbeelding doel 1',
//		    'type'  => 'image',
//		    'upload'    => true,
//		    'crop'  => true,
//		    'aspect_ratio'  => 2,
//		    'fake'  => true,
//		    'store_in'  => 'extras',
//		    'tab'   => 'Doelen',
//	    ]);
//	    $this->crud->addField([
//		    'name'  => 'goal_1_url',
//		    'label' => 'Link doel 1',
//		    'type'  => 'page_or_link',
//		    'page_model'    => 'App\Models\Page',
//		    'fake'  => true,
//		    'store_in'  => 'extras',
//		    'tab'   => 'Doelen',
//	    ]);
//	    $this->crud->addField([
//	    	'name'  => 'separator_1',
//		    'type'  => 'custom_html',
//		    'value' => '<hr>',
//		    'tab'   => 'Doelen',
//	    ]);
//
//	    $this->crud->addField([
//		    'name'  => 'goal_2_title',
//		    'label' => 'Titel doel 2',
//		    'type'  => 'text',
//		    'placeholder'   => 'Titel doel 2',
//		    'fake'  => true,
//		    'store_in'  => 'extras',
//		    'tab'   => 'Doelen',
//	    ]);
//	    $this->crud->addField([
//		    'name'  => 'goal_2_img',
//		    'label' => 'Afbeelding doel 2',
//		    'type'  => 'image',
//		    'upload'    => true,
//		    'crop'  => true,
//		    'aspect_ratio'  => 2,
//		    'fake'  => true,
//		    'store_in'  => 'extras',
//		    'tab'   => 'Doelen',
//	    ]);
//	    $this->crud->addField([
//		    'name'  => 'goal_2_url',
//		    'label' => 'Link doel 2',
//		    'type'  => 'page_or_link',
//		    'page_model'    => 'App\Models\Page',
//		    'fake'  => true,
//		    'store_in'  => 'extras',
//		    'tab'   => 'Doelen',
//	    ]);
//	    $this->crud->addField([
//		    'name'  => 'separator_2',
//		    'type'  => 'custom_html',
//		    'value' => '<hr>',
//		    'tab'   => 'Doelen',
//	    ]);
//
//	    $this->crud->addField([
//		    'name'  => 'goal_3_title',
//		    'label' => 'Titel doel 3',
//		    'type'  => 'text',
//		    'placeholder'   => 'Titel doel 3',
//		    'fake'  => true,
//		    'store_in'  => 'extras',
//		    'tab'   => 'Doelen',
//	    ]);
//	    $this->crud->addField([
//		    'name'  => 'goal_3_img',
//		    'label' => 'Afbeelding doel 3',
//		    'type'  => 'image',
//		    'upload'    => true,
//		    'crop'  => true,
//		    'aspect_ratio'  => 2,
//		    'fake'  => true,
//		    'store_in'  => 'extras',
//		    'tab'   => 'Doelen',
//	    ]);
//	    $this->crud->addField([
//		    'name'  => 'goal_3_url',
//		    'label' => 'Link doel 3',
//		    'type'  => 'page_or_link',
//		    'page_model'    => 'App\Models\Page',
//		    'fake'  => true,
//		    'store_in'  => 'extras',
//		    'tab'   => 'Doelen',
//	    ]);
//	    $this->crud->addField([
//		    'name'  => 'separator_3',
//		    'type'  => 'custom_html',
//		    'value' => '<hr>',
//		    'tab'   => 'Doelen',
//	    ]);
//
//	    $this->crud->addField([
//		    'name'  => 'goal_4_title',
//		    'label' => 'Titel doel 4',
//		    'type'  => 'text',
//		    'placeholder'   => 'Titel doel 4',
//		    'fake'  => true,
//		    'store_in'  => 'extras',
//		    'tab'   => 'Doelen',
//	    ]);
//	    $this->crud->addField([
//		    'name'  => 'goal_4_img',
//		    'label' => 'Afbeelding doel 4',
//		    'type'  => 'image',
//		    'upload'    => true,
//		    'crop'  => true,
//		    'aspect_ratio'  => 2,
//		    'fake'  => true,
//		    'store_in'  => 'extras',
//		    'tab'   => 'Doelen',
//	    ]);
//	    $this->crud->addField([
//		    'name'  => 'goal_4_url',
//		    'label' => 'Link doel 4',
//		    'type'  => 'page_or_link',
//		    'page_model'    => 'App\Models\Page',
//		    'fake'  => true,
//		    'store_in'  => 'extras',
//		    'tab'   => 'Doelen',
//	    ]);

        $this->crud->addField([
            'name' => 'content_text_block_goals_title',
            'label' => trans('Titel'),
            'type' => 'text',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Content blok 3",
        ]);
        $this->crud->addField([
            'name' => 'content_text_block_goals',
            'label' => trans('backpack::pagemanager.content'),
            'type' => 'wysiwyg',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Content blok 3",
        ]);
        $this->crud->addField([
            'name' => 'image2',
            'label' => 'Afbeelding feiten',
            'type' => 'image',
            'crop' => 'true',
            'aspect_ratio' => 0,
            'upload' => true,
            'disk' => 'uploads',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Feiten',
        ]);
        $this->crud->addField([
            'name'              => 'facts',
            'label'             => 'Feiten',
            'type'              => 'table',
            'entity_singular'   => 'feit',
            'columns'           => [
                'name'          => 'Naam',
            ],
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Feiten",
        ]);
    }

    private function template_landingspage()
    {
        $this->crud->addField([
            'name' => 'meta_title',
            'label' => trans('backpack::pagemanager.meta_title'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Meta informatie',
        ]);
        $this->crud->addField([
            'name' => 'meta_description',
            'label' => trans('backpack::pagemanager.meta_description'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Meta informatie',
        ]);
        $this->crud->addField([
            'name' => 'meta_keywords',
            'type' => 'textarea',
            'label' => trans('backpack::pagemanager.meta_keywords'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Meta informatie',
        ]);
        $this->crud->addField([
            'name' => 'content',
            'label' => trans('backpack::pagemanager.content'),
            'type' => 'wysiwyg',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'tab' => 'Header',
        ]);
        $this->crud->addField([
            'name' => 'image',
            'label' => 'Afbeelding header',
            'type' => 'image',
            'crop' => 'true',
            'aspect_ratio' => 0,
            'upload' => true,
            'disk' => 'uploads',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Header',
        ]);
        $this->crud->addField([   // CustomHTML
            'name' => 'title_usp1',
            'label' => 'USP 1',
            'type' => 'text',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "USP's",
        ]);
        $this->crud->addField([   // CustomHTML
            'name' => 'title_usp2',
            'label' => 'USP 2',
            'type' => 'text',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "USP's",
        ]);
        $this->crud->addField([   // CustomHTML
            'name' => 'title_usp3',
            'label' => 'USP 3',
            'type' => 'text',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "USP's",
        ]);
    }

    private function how_it_works()
    {
        $this->crud->addField([
            'name' => 'meta_title',
            'label' => trans('backpack::pagemanager.meta_title'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Meta informatie',
        ]);
        $this->crud->addField([
            'name' => 'meta_description',
            'label' => trans('backpack::pagemanager.meta_description'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Meta informatie',
        ]);
        $this->crud->addField([
            'name' => 'meta_keywords',
            'type' => 'textarea',
            'label' => trans('backpack::pagemanager.meta_keywords'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Meta informatie',
        ]);
        $this->crud->addField([   // CustomHTML
            'name' => 'content_separator1',
            'type' => 'custom_html',
            'value' => '<br><h2>'.trans('Content tab 1').'</h2><hr>',
            'tab' => 'Tabs',
        ]);
        $this->crud->addField([
            'name' => 'title_tab1',
            'label' => trans('Titel 1e tab'),
            'type' => 'text',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Tabs',
        ]);
        $this->crud->addField([
            'name' => 'content_tab1',
            'label' => trans('Content 1e tab'),
            'type' => 'wysiwyg',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Tabs',
        ]);
        $this->crud->addField([   // CustomHTML
            'name' => 'content_separator2',
            'type' => 'custom_html',
            'value' => '<br><h2>'.trans('Content tab 2').'</h2><hr>',
            'tab' => 'Tabs',
        ]);
        $this->crud->addField([
            'name' => 'title_tab2',
            'label' => trans('Titel 2e tab'),
            'type' => 'text',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Tabs',
        ]);
        $this->crud->addField([
            'name' => 'content_tab2',
            'label' => trans('Content 2e tab'),
            'type' => 'wysiwyg',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Tabs',
        ]);
        $this->crud->addField([   // CustomHTML
            'name' => 'content_separator3',
            'type' => 'custom_html',
            'value' => '<br><h2>'.trans('Content tab 3').'</h2><hr>',
            'tab' => 'Tabs',
        ]);
        $this->crud->addField([
            'name' => 'title_tab3',
            'label' => trans('Titel 3e tab'),
            'type' => 'text',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Tabs',
        ]);
        $this->crud->addField([
            'name' => 'content_tab3',
            'label' => trans('Content 3e tab'),
            'type' => 'wysiwyg',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Tabs',
        ]);
        $this->crud->addField([   // CustomHTML
            'name' => 'content_separator4',
            'type' => 'custom_html',
            'value' => '<br><h2>'.trans('Content tab 4').'</h2><hr>',
            'tab' => 'Tabs',
        ]);
        $this->crud->addField([
            'name' => 'title_tab4',
            'label' => trans('Titel 4e tab'),
            'type' => 'text',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Tabs',
        ]);
        $this->crud->addField([
            'name' => 'content_tab4',
            'label' => trans('Content 4e tab'),
            'type' => 'wysiwyg',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Tabs',
        ]);
        $this->crud->addField([   // CustomHTML
            'name' => 'title_usp1',
            'label' => 'USP 1',
            'type' => 'text',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "USP's",
        ]);
        $this->crud->addField([   // CustomHTML
            'name' => 'title_usp2',
            'label' => 'USP 2',
            'type' => 'text',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "USP's",
        ]);
        $this->crud->addField([   // CustomHTML
            'name' => 'title_usp3',
            'label' => 'USP 3',
            'type' => 'text',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "USP's",
        ]);
        $this->crud->addField([
            'name' => 'image',
            'label' => 'Afbeelding header',
            'type' => 'image',
            'crop' => 'true',
            'aspect_ratio' => 0,
            'upload' => true,
            'disk' => 'uploads',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Content blok',
        ]);
        $this->crud->addField([
            'name' => 'content_text_block_title',
            'label' => trans('Titel'),
            'type' => 'text',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Content blok",
        ]);
        $this->crud->addField([
            'name' => 'content_text_block',
            'label' => trans('backpack::pagemanager.content'),
            'type' => 'wysiwyg',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Content blok",
        ]);
        $this->crud->addField([
            'name' => 'why_title',
            'label' => trans('Titel'),
            'type' => 'text',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Blok 1 - Waarom",
        ]);
        $this->crud->addField([
            'name'              => 'why',
            'label'             => 'Waarom',
            'type'              => 'table',
            'entity_singular'   => 'why',
            'columns'           => [
                'name'          => 'Naam',
            ],
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Blok 1 - Waarom",
        ]);
        $this->crud->addField([
            'name' => 'afford_title',
            'label' => trans('Titel'),
            'type' => 'text',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Blok 2 - Wat levert X op",
        ]);
        $this->crud->addField([
            'name'              => 'afford',
            'label'             => 'Wat levert X uw werknemers op',
            'type'              => 'table',
            'entity_singular'   => 'afford',
            'columns'           => [
                'name'          => 'Naam',
            ],
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Blok 2 - Wat levert X op",
        ]);
    }

    private function template_prices()
    {
        $this->crud->addField([
            'name' => 'meta_title',
            'label' => trans('backpack::pagemanager.meta_title'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Meta informatie',
        ]);
        $this->crud->addField([
            'name' => 'meta_description',
            'label' => trans('backpack::pagemanager.meta_description'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Meta informatie',
        ]);
        $this->crud->addField([
            'name' => 'meta_keywords',
            'type' => 'textarea',
            'label' => trans('backpack::pagemanager.meta_keywords'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Meta informatie',
        ]);

        $this->crud->addField([
            'name' => 'package_block_1_title',
            'label' => trans('Titel'),
            'type' => 'text',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Pakket 1",
        ]);
        $this->crud->addField([
            'name' => 'package_block_1_price',
            'label' => trans('Prijs per maand'),
            'type' => 'text',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Pakket 1",
            'class' => 'col-lg-6',
        ]);
        $this->crud->addField([
            'name'              => 'package_block_1_content',
            'label'             => 'Inhoud pakket 1',
            'type'              => 'table',
            'entity_singular'   => 'item',
            'columns'           => [
                'name'          => 'Naam',
            ],
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Pakket 1",
        ]);
        $this->crud->addField([
            'name' => 'package_block_1_text',
            'label' => trans('Tekst'),
            'type' => 'textarea',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Pakket 1",
        ]);

        $this->crud->addField([
            'name' => 'package_block_2_title',
            'label' => trans('Titel'),
            'type' => 'text',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Pakket 2",
        ]);
        $this->crud->addField([
            'name' => 'package_block_2_price',
            'label' => trans('Prijs per maand'),
            'type' => 'text',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Pakket 2",
        ]);
        $this->crud->addField([
            'name'              => 'package_block_2_content',
            'label'             => 'Inhoud pakket 2',
            'type'              => 'table',
            'entity_singular'   => 'item',
            'columns'           => [
                'name'          => 'Naam',
            ],
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Pakket 2",
        ]);
        $this->crud->addField([
            'name' => 'package_block_2_text',
            'label' => trans('Tekst'),
            'type' => 'textarea',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Pakket 2",
        ]);

        $this->crud->addField([
            'name' => 'package_block_3_title',
            'label' => trans('Titel'),
            'type' => 'text',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Pakket 3",
        ]);
        $this->crud->addField([
            'name' => 'package_block_3_price',
            'label' => trans('Prijs per maand'),
            'type' => 'text',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Pakket 3",
        ]);
        $this->crud->addField([
            'name'              => 'package_block_3_content',
            'label'             => 'Inhoud pakket 3',
            'type'              => 'table',
            'entity_singular'   => 'item',
            'columns'           => [
                'name'          => 'Naam',
            ],
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Pakket 3",
        ]);
        $this->crud->addField([
            'name' => 'package_block_3_text',
            'label' => trans('Tekst'),
            'type' => 'textarea',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Pakket 3",
        ]);
    }

    private function template_content()
    {
        $this->crud->addField([
            'name' => 'meta_title',
            'label' => trans('backpack::pagemanager.meta_title'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Meta informatie',
        ]);
        $this->crud->addField([
            'name' => 'meta_description',
            'label' => trans('backpack::pagemanager.meta_description'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Meta informatie',
        ]);
        $this->crud->addField([
            'name' => 'meta_keywords',
            'type' => 'textarea',
            'label' => trans('backpack::pagemanager.meta_keywords'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Meta informatie',
        ]);
        $this->crud->addField([
            'name' => 'title',
            'label' => trans('Titel'),
            'type' => 'text',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'fake' => true,
            'store_in' => 'extras',
            'tab' => "Content blok",
        ]);
        $this->crud->addField([
            'name' => 'content',
            'label' => trans('backpack::pagemanager.content'),
            'type' => 'wysiwyg',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
            'tab' => "Content blok",
        ]);
    }
}
