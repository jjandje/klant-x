<?php

namespace App\Http\Controllers;

use App\Models\BackpackUser;
use App\Models\Goal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProfileGoalsController extends Controller
{
	public function index() {
		$goals = Goal::all();
		return view(backpack_view('profile.goals.index'), ['goals' => $goals]);
	}

	public function show( $slug ) {
		$goal = Goal::where('slug', $slug)->first();
        return view(backpack_view('profile.goals.show'), ['goal' => $goal]);
	}

	public function getInactiveGoals( Request $request ) {
		if(!$request->get('uid')) return response()->json(['error' => 'no user id has been provided, aborting']);
		$user = BackpackUser::findOrFail($request->get('uid'));
		$view = \View::make(config('backpack.base.view_namespace').'profile.goals.partials.inactive-user-goals')->with(['goals' => $user->inactiveGoals()])->render();
		return response()->json(['success' => true, 'view' => $view]);
	}

	public function goalAction( Request $request ) {
		if(!$request->get('uid') || !$request->get('gid') || !$request->get('action')) return response()->json(['error' => 'user, goal or action not found']);
		$user = BackpackUser::find($request->get('uid'));
		$goal = Goal::find($request->get('gid'));
		$action = $request->get('action');
		$now = Carbon::now();
		$finish_date = $now->copy()->addWeeks($goal->duration);

		switch($action) {
			case 'addgoal':
				$relation_exists = $user->goals->contains($goal->id);
				if(!$relation_exists) {
					$user->goals()->attach($goal->id, ['active' => 1]);
				} else {
					$update_result = $user->goals()->updateExistingPivot($goal->id, ['active' => 1]);
					if(!$update_result) return response()->json(['success' => false, 'message' => 'Unable to update active state']);
				}
				break;
			case 'startgoal':
				$relation_exists = $user->goals->contains($goal->id);
				if(!$relation_exists) {
					$user->goals()->attach($goal->id, ['active' => 1, 'start_date' => $now, 'finish_date' => $finish_date]);
				} else {
					$update_result = $user->goals()->updateExistingPivot($goal->id, ['active' => 1, 'start_date' => $now, 'finish_date' => $finish_date]);
					if(!$update_result) return response()->json(['success' => false, 'message' => 'Unable to update active state']);
				}
				break;
			case 'stopgoal':
				$update_result = $user->goals()->updateExistingPivot($goal->id, ['start_date' => null, 'active' => 0, 'finish_date' => null]);
				if(!$update_result) return response()->json(['success' => false, 'message' => 'Unable to update user\'s goal']);
				break;
			case 'restartgoal':
				$update_result = $user->goals()->updateExistingPivot($goal->id, ['start_date' => $now, 'finish_date' => $finish_date]);
				if(!$update_result) return response()->json(['success' => false, 'message' => 'Unable to update user\'s goal']);
				break;
		}

		$view = \View::make(config('backpack.base.view_namespace').'profile.goals.partials.user-goals')->with(['user_goals' => $user->activeGoals()])->render();
		return response()->json(['success' => true, 'view' => $view]);

	}
}
