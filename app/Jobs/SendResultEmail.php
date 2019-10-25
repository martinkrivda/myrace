<?php

namespace App\Jobs;

use App\Mail\RunnerFinished;
use App\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendResultEmail implements ShouldQueue {
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public $runner;
	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(Registration $runner) {
		$this->runner = (object) $runner;
		Log::warn($this->runner->email);
	}

	/**
	 * The number of times the job may be attempted.
	 *
	 * @var int
	 */
	public $tries = 3;

	/**
	 * The number of seconds the job can run before timing out.
	 *
	 * @var int
	 */
	public $timeout = 60;

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {
		$email = new RunnerFinished($this->runner);
		Mail::to($this->runner->email)->send($email);
	}
}