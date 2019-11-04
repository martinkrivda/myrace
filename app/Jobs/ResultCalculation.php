<?php

namespace App\Jobs;

use App\Helpers;
use App\Mail\RunnerFinished;
use App\Notification;
use App\RaceEdition;
use App\Registration;
use App\RfidReader;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ResultCalculation implements ShouldQueue {
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
	public $tries = 4;

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
		$lastRead = (int) 0;
		$races = RaceEdition::whereDate('date', date('Y-m-d', time()))->select('date AS eventdate', 'firststart', 'edition_ID')->get();
		if ($races == null) {
			Log::warn('No race for proccessing');
			return;
		}

		while (true) {
			// Your Database Logic
			Log::info('Service is available');
			foreach ($races as $race) {
				$runners = Registration::leftJoin('starttime', 'registration.stime_ID', '=', 'starttime.stime_ID')->leftJoin('runner', 'registration.runner_ID', '=', 'runner.runner_ID')->leftJoin('club', 'registration.club_ID', '=', 'club.club_ID')->leftJoin('tag', 'starttime.tag_ID', '=', 'tag.tag_ID')->where('registration.edition_ID', $race->edition_ID)->whereNotNull('registration.stime_ID')->select('registration.*', 'starttime.*', 'tag.*', 'club.clubname', 'club.club_ID', 'runner.email')->get();
				$reader = RfidReader::where('edition_ID', $race->edition_ID)->where('gateway', 'F')->where('read_ID', '>', $lastRead)->select('read_ID', 'EPC', 'time')->get();
				foreach ($runners as $key => $runner) {
					if ($runner->DNS == false) {
						$tag = $runner->EPC;
						$records = array();
						foreach ($reader as $key => $read) {
							if ($tag === $read->EPC) {
								$records[] = $read;
								$reader->forget($key);
							}
						}

						$sort = usort($records, function ($a, $b) {return $a->time > $b->time;});
						foreach ($records as $key => $record) {
							if ($record->time >= $runner->stime) {
								$runner->timems = strtotime($record->time) - strtotime($runner->stime);
								// Save time to DB
								$runner->save();
								if ($runner->status < 8) {
									if ($runner->email != '') {
										$notification = new Notification;
										$notification->registration_ID = $runner->registration_ID;
										$notification->type = 'finish';
										$notification->kind = 'E';
										$notification->text = 'Runner: ' . $runner->lastname . ' ' . $runner->firstname . ' in finish ' . date('H:i:s', $runner->timems) . '.';
										$notification->email = $runner->email;
										$notification->save();
										if (Helpers::settings('sendFinishEmail') === 'Yes') {
											if (Helpers::settings('emailQueueing') === 'Yes') {
												$message = (new RunnerFinished($runner))->onQueue('emails');
												Mail::to($runner->email)->queue($message);
											} else {
												Mail::to($runner->email)->send(new RunnerFinished($runner));
											}

										}
										$runner->status = 8;
										$runner->save();
									}
								}
								break;
							}
						}
					}
				}
				if ($reader->isNotEmpty()) {
					$lastRead = $reader->last()->read_ID;
				}
				Log::info('Result times calculated.', ['last_id:' => $lastRead]);
			}
			sleep(4);
		}
	}
}
