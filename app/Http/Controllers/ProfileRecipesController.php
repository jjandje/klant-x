<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Recipe;
use App\Models\Goal;
use App\Models\BackpackUser;
use Illuminate\Http\Request;

class ProfileRecipesController extends Controller
{
    public function index(  ) {
        $recipes = Recipe::orderBy('id', 'desc')->get();
//        $goals = Goal::whereHas('recipes')->orderBy('slug', 'asc')->get();
        $categories = Category::whereHas('recipes')->orderBy('slug', 'asc')->get();
        $dishes = Dish::whereHas('recipes')->orderBy('slug', 'asc')->get();
        return view(backpack_view('profile.recipes.index'), ['recipes' => $recipes, 'dishes' => $dishes, 'categories' => $categories]);
    }

    public function show( $slug ) {
        $recipe = Recipe::where('slug', $slug)->first();
        return view(backpack_view('profile.recipes.show'), ['recipe' => $recipe]);
    }

	public function addToFavorite( Request $request ) {
		if(!$request->get('uid') || !$request->get('rid')) return response()->json(['error' => 'user or recipe not found']);
		$user = BackpackUser::find($request->get('uid'));
		$recipe = Recipe::find($request->get('rid'));

		$relation_exists = $user->favoriteRecipes->contains($recipe->id);

		$state = 'active';
		$success = true;
		$message = '';
		if($relation_exists) {
			// relation exists, so delete it.
			$user->favoriteRecipes()->detach($recipe->id);
			$state = 'inactive';
			$success = false;
			$message = 'Recept is verwijdert van favorieten';
		} else {
			$user->favoriteRecipes()->attach($recipe->id);
			$message = 'Recept toegevoegt aan favorieten. Je kunt het recept terugvinden in <a href="'.route('backpack.profile.show').'">je profiel</a>.';
		}

		return response()->json(['success' => $success, 'state' => $state, 'message' => $message]);
    }
}
