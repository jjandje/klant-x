<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Goal;
use App\Models\BackpackUser;
use Illuminate\Http\Request;

class ProfileArticlesController extends Controller
{
    public function index(  ) {
        $articles = Article::orderBy('id', 'desc')->get();
	    $goals = Goal::with('recipes')->orderBy('slug', 'asc')->get();
        return view(backpack_view('profile.articles.index'), ['articles' => $articles, 'goals' => $goals]);
    }

    public function show( $slug ) {
        $article = Article::where('slug', $slug)->first();
        return view(backpack_view('profile.articles.show'), ['article' => $article]);
    }

	public function addToFavorite( Request $request ) {
		if(!$request->get('uid') || !$request->get('aid')) return response()->json(['error' => 'user or article not found']);
		$user = BackpackUser::find($request->get('uid'));
		$article = Article::find($request->get('aid'));

		$relation_exists = $user->favoriteArticles->contains($article->id);

		$state = 'active';
		$success = true;
        $message = '';
		if($relation_exists) {
			// relation exists, so delete it.
			$user->favoriteArticles()->detach($article->id);
			$state = 'inactive';
			$success = false;
            $message = 'Blogitem is verwijdert van favorieten';
		} else {
			$user->favoriteArticles()->attach($article->id);
            $message = 'Blog toegevoegt aan favorieten. Je kunt het blogitem terugvinden in <a href="'.route('backpack.profile.show').'">je profiel</a>.';
		}

		return response()->json(['success' => $success, 'state' => $state, 'message' => $message]);
	}
}
