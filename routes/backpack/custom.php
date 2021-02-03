<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
	'prefix'    => config('backpack.base.route_prefix', 'admin'),
	'middleware'    => ['web', config('backpack.base.middleware_key', 'admin')],
	'namespace'     => 'App\Http\Controllers',
], function() {

	// Only accessible for the users that have userinfo set
	Route::group([
		'middleware'    => 'hasuserinfo',
	], function() {
		Route::get('dashboard', 'AdminController@dashboard')->name('backpack.dashboard');
		Route::get('/', 'AdminController@redirect')->name('backpack');

		// my profile
		Route::crud('profile', 'ProfileCrudController');
		Route::get('profile/edit-password', 'ProfileCrudController@editPassword')->name('backpack.account.password');
		Route::post('profile/edit-password', 'ProfileCrudController@postPassword');

		// Goals
		Route::get('goals', 'ProfileGoalsController@index')->name('profile.goals');
		Route::get('goals/{slug}', 'ProfileGoalsController@show')->name('profile.goals.show');
		Route::post('goals/goalaction', 'ProfileGoalsController@goalAction');
		Route::post('goals/inactivegoals', 'ProfileGoalsController@getInactiveGoals');

        // Articles
        Route::get('blogs', 'ProfileArticlesController@index')->name('profile.articles');
        Route::get('blogs/{slug}', 'ProfileArticlesController@show')->name('profile.articles.show');
        Route::post('blogs/addtofavorite', 'ProfileArticlesController@addToFavorite');

        // recipes
        Route::get('recipes', 'ProfileRecipesController@index')->name('profile.recipes');
        Route::get('recipes/{slug}', 'ProfileRecipesController@show')->name('profile.recipes.show');
        Route::post('recipes/addtofavorite', 'ProfileRecipesController@addToFavorite');

        // coaches
        Route::get('coaches', 'ProfileCoachesController@index')->name('profile.coaches');
        Route::post('coaches', 'ProfileCoachesController@sendMessage')->name('profile.coaches.send');
	});

	Route::group([
//		'middleware'    => null,
	], function() {
		Route::get('clients', 'CoachClientsController@index')->name('coach.clients');
		Route::get('clients/{id}', 'CoachClientsController@showClient')->name('coach.clients.show');
		Route::post('clients/{id}', 'CoachClientsController@sendMessage')->name('coach.clients.send');
	});

	// Page to set userinfo
	Route::get('profile/create', 'ProfileCrudController@create')->name('backpack.account.create');
	Route::post('profile/create', 'ProfileCrudController@store');
});

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
	// TODO:we will probably use packages in v2
	// Route::crud('package', 'PackageCrudController');
    Route::crud('application', 'ApplicationCrudController');
    Route::crud('company', 'CompanyCrudController');

    // employees view for selected company
	Route::group([
		'prefix'        => 'company/{company_id}',
		'middleware'    => ['isusercompany'],
	], function() {
		Route::crud('employees', 'CompanyEmployeesCrudController');
	});
    Route::crud('goal', 'GoalCrudController');
    Route::crud('blog', 'ArticleCrudController');
    Route::crud('recipe', 'RecipeCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('dish', 'DishCrudController');
}); // this should be the absolute last line of this file
