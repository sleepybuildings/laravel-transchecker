<?php namespace Sleepybuildings\Transchecker\Errors;

/**
 * Class MissingFileError
 *
 */
class MissingFileError
{
	public $language;
	public $namespace;


	public function toArray()
	{
		return [$this->language, $this->namespace];
	}
}