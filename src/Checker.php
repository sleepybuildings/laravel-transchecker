<?php namespace Sleepybuildings\Transchecker;
use Sleepybuildings\Transchecker\Errors\EmptyEntryError;
use Sleepybuildings\Transchecker\Errors\MissingEntryError;
use Sleepybuildings\Transchecker\Errors\MissingFileError;

/**
 * Class Checker
 *
 * @package Sleepybuildings\Transchecker
 */
class Checker
{


	/**
	 * @var Languages
	 */
	private $languages;

	/**
	 * @var Namespaces
	 */
	private $namespaces;


	private $skipFiles = [];


	public function __construct()
	{
		$this->languages = new Languages;
		$this->namespaces = new Namespaces;

		$this->namespaces->findNamespaces($this->languages);
	}


	protected function skipFile($lang, $namespace)
	{
		$this->skipFiles[] = Utils::getLanguageFilename($lang, $namespace);
	}


	/**
	 * Check if all the language files are there
	 *
	 * @param \Closure|null $errorCallback
	 */
	public function findMissingFiles(\Closure $errorCallback)
	{
		$this->namespaces->each(function($namespace) use ($errorCallback)
		{
			$this->languages->each(function($language) use ($namespace, $errorCallback)
			{
				$filename = Utils::getLanguageFilename($language, $namespace);
				if(!file_exists($filename))
				{
					$error = new MissingFileError();
					$error->language = $language;
					$error->namespace = $namespace;

					$errorCallback($error);

					$this->skipFile($language, $namespace);
				}
			});
		});
	}


	protected function loadLanguageFile($lang, $namespace)
	{
		$filename = Utils::getLanguageFilename($lang, $namespace);
		if(!file_exists($filename))
			throw new \Exception('Cannot include language file ' . $filename);

		return require($filename);
	}


	public function findAllMissingNamespaceEntries(\Closure $errorCallback)
	{
		$this->namespaces->each(function($namespace) use ($errorCallback)
		{
			$missing = $this->findMissingNamespaceEntries($namespace);
			if($missing)
				$errorCallback($missing);
		});
	}


	public function findMissingNamespaceEntries($namespace)
	{
		if(!$this->namespaces->contains($namespace))
			throw new \Exception('Invalid namespace: ' . $namespace);

		$missing = [];
		$entries = [];
		$unique = [];

		foreach($this->languages as $lang)
		{
			$filename = Utils::getLanguageFilename($lang, $namespace);
			if(in_array($filename, $this->skipFiles))
				continue;

			$entries[$lang] = $this->loadLanguageFile($lang, $namespace);

			$unique = array_merge($unique, array_keys($entries[$lang]));
		}


		foreach(array_unique($unique) as $entry)
			foreach(array_keys($entries) as $lang)
			{
				$error = null;

				if(!isset($entries[$lang][$entry]))
					$error = new MissingEntryError;
				else if(is_string($entries[$lang][$entry]) && !strlen(trim($entries[$lang][$entry])))
					$error = new EmptyEntryError;

				if($error)
				{
					$error->language = $lang;
					$error->namespace = $namespace;
					$error->entry = $entry;
					$missing[] = $error;
				}
			}

		return $missing;
	}


	/**
	 * @return Languages
	 */
	public function getLanguages()
	{
		return $this->languages;
	}

	/**
	 * @return Namespaces
	 */
	public function getNamespaces()
	{
		return $this->namespaces;
	}


}