<?php

namespace App\Mail;

use App\Models\BackpackUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CoachUserAnswerMail extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($onderwerp, $message, BackpackUser $coach, BackpackUser $user)
	{
		$this->onderwerp = $onderwerp;
		$this->message = $message;
		$this->coach = $coach;
		$this->user = $user;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->subject($this->coach->name.' heeft je vraag beantwoord.')
		            ->markdown('emails.coaches.coach-answer')
		            ->with([
			            'onderwerp' => $this->onderwerp,
			            'message'   => $this->message,
			            'coach'     => $this->coach,
			            'user'      => $this->user,
		            ]);
	}
}
