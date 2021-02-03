<?php

namespace App\Mail;

use App\Models\BackpackUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(BackpackUser $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	    return $this->subject('Welkom bij '.config('app.name'))
	                ->markdown('emails.user.welcome')
	                ->with([
		                'user'              => $this->user,
		                'token'             => $this->token,
	                ]);
    }
}
