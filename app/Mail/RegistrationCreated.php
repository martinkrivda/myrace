<?php

namespace App\Mail;

use App\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationCreated extends Mailable {
	use Queueable, SerializesModels;

	public $registration;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Registration $registration) {
		$this->registration = $registration;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
		return $this->from('notification@chytryoddil.cz')
			->view('emails.registrations.created');
	}
}
