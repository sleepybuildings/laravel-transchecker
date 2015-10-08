<?php namespace Sleepybuildings\Transchecker\Errors;

/**
 * Class MissingEntryError
 *
 * @package Sleepybuildings\Transchecker\Errors
 */
class EmptyEntryError extends MissingEntryError
{
	public function toArray()
	{
		return [$this->language, $this->namespace, $this->entry, 'Empty'];
	}

}