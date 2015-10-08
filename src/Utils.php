<?php namespace Sleepybuildings\Transchecker;

/**
 * Class LanguageUtils
 *
 */
abstract class Utils
{



	static public function getLangDirectory($lang = null)
	{
		return app('path') . '/../resources/lang/' . $lang;
	}


	static public function getLanguageFilename($lang, $namespace)
	{
		return app('path') . '/../resources/lang/' . $lang . '/' . $namespace . '.php';
	}

}