<?php namespace Sleepybuildings\Transchecker\Console;

use Illuminate\Console\Command;
use Sleepybuildings\Transchecker\Checker;
use Sleepybuildings\Transchecker\LanguageFiles;

/**
 * Class TransChecker
 *
 */
class TransChecker extends Command
{
	protected $name = 'lang:check';

	protected $description = 'Checks the language files';

	protected $checker;

	protected $errors = 0;


	public function fire(Checker $checker)
	{
		$this->checker = $checker;

		if($checker->getLanguages()->isEmpty())
		{
			$this->error('No languages found!');
			return;
		}

		$this->info('<comment>Languages found:</comment> '  . (string)$checker->getLanguages());
		$this->info('<comment>Namespaces found:</comment> ' . (string)$checker->getNamespaces());

		$this->info('Checking files...');

		$this->checkMissingFiles();
		$this->checkMissingEntries();

		$this->info('Finished with ' . $this->errors . ' error' . ($this->errors > 1? 's' : null));
	}


	protected function checkMissingFiles()
	{
		$missingFiles = [];
		$this->checker->findMissingFiles(function($error) use(&$missingFiles)
		{
			$missingFiles[] = $error->toArray();
		});

		if($missingFiles)
		{
			$counted = count($missingFiles);
			$this->errors += $counted;

			$this->error($counted === 1? 'There is 1 missing file:' : 'There are ' . $counted . ' missing files:');
			$this->table(['Language', 'Namespace'], $missingFiles);
		}
	}


	protected function checkMissingEntries()
	{
		$missing = [];
		$this->checker->findAllMissingNamespaceEntries(function($errors) use (&$missing)
		{
			foreach($errors as $error)
				$missing[] = $error->toArray();
		});

		if($missing)
		{
			$counted = count($missing);
			$this->errors += $counted;

			$this->error($counted === 1? 'There is 1 missing entry:' : 'There are ' . $counted . ' missing entries:');
			$this->table(['Language', 'Namespace', 'Entry', 'Error'], $missing);
		}

	}
}