<?php

namespace App\Http\Controllers;

use App\Mail\CoachUserQuestionMail;
use App\Models\BackpackUser;
use App\Models\Goal;
use App\Models\UserMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProfileCoachesController extends Controller
{
    public function index(  )
    {
    	$user = backpack_user();
        $coaches = $user->coaches;
        $goals = Goal::get()->map->only(['title', 'slug']);
        return view(backpack_view('profile.coaches.index'), ['coaches' => $coaches, 'goals' => $goals]);
    }

	public function sendMessage( Request $request )
	{
		$errors = [];
		if(!$request->get('subject') || empty($request->get('subject')) || $request->get('subject') == 'Maak een keuze') $errors[] = __('requests.required.subject');
		if(!$request->get('message')) $errors[] = __('requests.required.message');
		if(!$request->get('coach_ids') || sizeof($request->get('coach_ids')) < 1) $errors[] = __('requests.required.coach_ids');
		if(!$request->get('user_id')) $errors[] = __('requests.required.user_id');
		if(!empty($errors)) return back()->with('errors', $errors)->withInput($request->input());

		$subject = $request->get('subject');
		$user_message = $request->get('message');

		$coach_ids = $request->get('coach_ids');
//		$coaches = BackpackUser::find($coach_ids);
		$user = BackpackUser::find($request->get('user_id'));
		$coaches = [];

		if(!empty($coach_ids)) {
			foreach($coach_ids as $coach_id) {
				// Find the coach
				$coach = BackpackUser::find($coach_id);
				if($coach) {
					// If we found a coach, create a new UserMessage model
					$message = new UserMessage();
					$message->subject = $subject;
					$message->message = $user_message;
					$message->sender()->associate($user);
					$message->recipient()->associate($coach);
					$message->save();

					$coaches[] = $coach;
				}
			}
		}

		// Once the UserMessage has been saved, send email(s) to site admin (and coach?)
		Mail::to('example@gmail.com')
		    ->send(new CoachUserQuestionMail($subject, $user_message, $coaches, $user));

		if(Mail::failures()) return back()->with('errors', ['Er is iets fout gegaan bij het versturen van de mail. Probeer het opnieuw']);

		$coach_string = count($coaches) > 1 ? 'coaches nemen' : 'coach neemt';

		return back()->with('success', 'We hebben uw vraag ontvangen! De '.$coach_string.' zo snel mogelijk contact met je op.');
    }
}
