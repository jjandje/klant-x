<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\BackpackUser;

class CoachUserQuestionMail extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($onderwerp, $message, array $coaches, BackpackUser $user)
	{
		$this->onderwerp = $onderwerp;
		$this->message = $message;
		$this->coaches = $coaches;
		$this->user = $user;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->subject($this->user->name.' heeft een vraag over '.implode(' ', explode('-', $this->onderwerp)).' voor de '.(count($this->coaches) > 1 ? 'coaches' : 'coach'))
		            ->markdown('emails.coaches.user-question')
		            ->with([
		            	'onderwerp' => $this->onderwerp,
			            'message'   => $this->message,
			            'coaches'   => $this->coaches,
			            'user'      => $this->user,
		            ]);
	}
}
