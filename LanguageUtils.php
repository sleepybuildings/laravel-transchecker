<?php namespace Sleepybuildings\Transchecker;

/**
 * Class LanguageUtils
 *
 */
abstract class LanguageUtils
{

	static public function getLangDirectory()
	{
		return app_path() . '/resources/lang/';
	}

}