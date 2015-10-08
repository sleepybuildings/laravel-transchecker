<?php namespace Sleepybuildings\Transchecker;

use Illuminate\Support\Collection;

/**
 * Class Namespaces
 *
 */
class Namespaces extends Collection
{


	public function findNamespaces(Languages $languages)
	{
		$languages->each(function($lang)
		{
			$dir = Utils::getLangDirectory($lang);
			if(!file_exists($dir))
				throw new \Exception('Cannot read directory for language ' . $lang);

			foreach(new \DirectoryIterator($dir) as $file)
				if($file->isFile())
				{
					$basename = $file->getBasename('.php');

					if(!$this->contains($basename))
						$this->push($basename);
				}
		});

		return $this;
	}


	public function __toString()
	{
		return join(', ', $this->items);
	}

}