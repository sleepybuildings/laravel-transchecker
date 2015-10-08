<?php namespace Sleepybuildings\Transchecker;

use Illuminate\Support\Collection;

/**
 * Class Languages
 *
 * Collection of found languages
 */
class Languages extends Collection
{

	public function __construct($items = [])
	{
		parent::__construct($items);

		$this->findLanguages();
	}


	/**
	 * Finds all the languages
	 *
	 * @throws \Exception
	 */
	private function findLanguages()
	{
		$dir = Utils::getLangDirectory();
		if(!file_exists($dir))
			throw new \Exception('Cannot find the laravel language directory: ' . $dir);

		foreach(new \DirectoryIterator($dir) as $dir)
			if(!$dir->isDot() && $dir->isDir())
				$this->push((string)$dir);
	}


	public function __toString()
	{
		return join(', ', $this->items);
	}


}