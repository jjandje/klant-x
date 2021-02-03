<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\MenuItem;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
	public function index($slug = '/', $subs = null)
	{
	    $page = Page::findBySlug($slug);
//	    $menu = MenuItem::getTree();

		if (!$page)
		{
			abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
		}

		$this->data['title'] = $page->title;
		$this->data['page'] = $page->withFakes();
//        $this->data['menu'] = $menu;

		return view('pages.'.$page->template, $this->data);
	}
}
