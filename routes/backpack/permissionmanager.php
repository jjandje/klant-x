<?php

Route::group([
	'prefix'     => config('backpack.base.route_prefix', 'admin'),
	'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
	'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
	Route::crud('user', 'UserCrudController');
}); // this should be the absolute last line of this file
