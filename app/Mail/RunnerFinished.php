<?php

namespace App\Mail;

use App\RaceEdition;
use App\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RunnerFinished extends Mailable {
	use Queueable, SerializesModels;

	public $runner;
	public $race;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Registration $runner) {
		$this->runner = $runner;
		$race = RaceEdition::find($runner->edition_ID);

	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build(RaceEdition $race) {
		return $this->from('notification@chytryoddil.cz')
			->markdown('emails.registrations.finished')->with([
			'actionUrl' => 'https://www.mcvv.org',
			'level' => 'ok',
			'race' => $race->editionname,
		]);
	}
}
