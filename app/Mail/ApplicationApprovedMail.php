<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\BackpackUser;
use App\Models\Company;

class ApplicationApproved extends Mailable
{
	public $password;

	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(BackpackUser $user, Company $company, $token)
	{
		$this->user = $user;
		$this->company = $company;
		$this->token = $token;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->subject('Aanmelding goedgekeurd!')
		            ->markdown('emails.application.approved')
		            ->with([
			            'user'              => $this->user,
			            'company'           => $this->company,
			            'token'             => $this->token,
		            ]);
	}
}
