<?php namespace Sleepybuildings\Transchecker\Errors;

/**
 * Class MissingEntryError
 *
 */
class MissingEntryError extends MissingFileError
{

	public $entry;


	public function toArray()
	{
		return [$this->language, $this->namespace, $this->entry, 'Missing'];
	}
}