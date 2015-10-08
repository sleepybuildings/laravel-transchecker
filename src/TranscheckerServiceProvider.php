<?php namespace Sleepybuildings\Transchecker;

use Illuminate\Support\ServiceProvider;

/**
 * Class TranscheckerServiceProvider
 *
 * @package Sleepybuildings\Transchecker
 */
class TranscheckerServiceProvider extends ServiceProvider
{

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->commands([
			\Sleepybuildings\Transchecker\Console\TransChecker::class
		]);
	}
}