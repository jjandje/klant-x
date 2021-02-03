<?php

namespace App\Http\Controllers;

use App\Models\BackpackUser;
use Illuminate\Http\Request;
use App\Models\UserMessage;
use Illuminate\Support\Facades\Mail;
use App\Mail\CoachUserAnswerMail;

class CoachClientsController extends Controller
{

	public function index(  )
	{
		$coach = backpack_user();
		$clients = $coach->clients;
		return view(backpack_view('coach.clients.index'), ['clients' => $clients]);
	}

	public function showClient( $id ) {
		$coach = backpack_user();
		$client = BackpackUser::findOrFail($id);
		return view(backpack_view('coach.clients.show'), ['coach' => $coach, 'client' => $client]);
	}

	public function sendMessage( $id, Request $request ) {
		$errors = [];
		if(!$request->get('subject')) $errors[] = 'Er is geen onderwerp ingevoerd';
		if(!$request->get('message')) $errors[] = 'Er is geen bericht ingevoerd';
		if(!$request->get('coach_id')) $errors[] = 'Er is wat mis gegaan. Ververs de pagina en probeer het opnieuw';
		if(!$id) $errors[] = 'Er is wat mis gegaan. Ververs de pagina en probeer het opnieuw';
		if(!empty($errors)) return back()->with('errors', $errors)->withInput($request->input());

		$onderwerp = $request->get('subject');
		$user_message = $request->get('message');
		$coach = BackpackUser::findOrFail($request->get('coach_id'));
		$client = BackpackUser::findOrFail($id);

		$message = new UserMessage();
		$message->subject = $onderwerp;
		$message->message = $user_message;
		$message->sender()->associate($coach);
		$message->recipient()->associate($client);
		$messageSave = $message->save();

		Mail::to($client->email)
		    ->send(new CoachUserAnswerMail($onderwerp, $user_message, $coach, $client));

		if(Mail::failures() || !$messageSave) return back()->with('errors', ['Er is iets fout gegaan bij het versturen van de mail. Probeer het opnieuw']);

		return back()->with('success', 'We hebben de mail verstuurd.');
	}

}
