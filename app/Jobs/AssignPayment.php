<?php

namespace App\Jobs;

use App\Payment;
use App\Registration;
use App\RegistrationSum;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AssignPayment implements ShouldQueue {
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/**
	 * The number of times the job may be attempted.
	 *
	 * @var int
	 */
	public $tries = 3;

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {
		try {
			$this->process();
		} catch (\Exception $e) {
			// Log your error somewhere
			Log::critical($e->getMessage());

			// Re-run process
			$this->process();
		}
	}

	protected function process() {
		$queue = \DB::table(config('queue.connections.database.table'))->orderBy('id')->get();
		foreach ($queue as $job) {
			$payload = json_decode($job->payload, true);
			if ($payload['displayName'] == self::class && $job->attempts == 0) {
				// same job in queue, skip
				Log::warn('job cancelled');
				return;
			}
		}

		$payments = Payment::all();
		$regSummary = RegistrationSum::all();

		foreach ($regSummary as $key => $summary) {
			$paid = $payments->where('vs', $summary->payref)->sum('amount');
			if ($summary->totalprice <= $paid) {
				if ($summary->status <= 3) {
					$summary->status = 3;
					$summary->save();
				}
				Log::info('Payment assigned');

				$entries = Registration::where('regsummary_ID', '=', $summary->regsummary_ID)->get();
				foreach ($entries as $key => $entry) {
					$entry->paid = true;
					if ($entry->status <= 2) {
						$entry->status = 2;
					}
					$entry->save();
				}
			}
			$filteredPayments = $payments->where('ss', '!=', null);
			foreach ($filteredPayments as $key => $payment) {
				$entry = Registration::where('payref', $payment->ss)->first();
				if ($entry && $entry->paid == false && $payment->amount >= $entry->entryfee) {
					$entry->paid = true;
					$entry->save();
				}
			}
		}

	}
}
