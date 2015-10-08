# laravel-transchecker

Simple Laravel Artisan command do check your language files for inconsistencies.

# What it does

Transchecker checks your languagefiles and can report the following errors:

- missing language files
- missing entries
- empty entries

# Installation

Install through Composer: https://packagist.org/packages/sleepybuildings/transchecker

Then add the Transchecker serviceprovider to the your app config:

```php
providers' => [
	...
	\Sleepybuildings\Transchecker\TranscheckerServiceProvider::class,
	...

]
```

Languagefiles needs to be in the `resources/lang` directory.

# Usage

Run the check by executing the following artisan command:

`php artisan lang:check`

# Sample output

```
>> php artisan lang:check
Languages found: en, nl
Namespaces found: auth, pagination, passwords, validation
Checking files...
There is 1 missing file:
+----------+------------+
| Language | Namespace  |
+----------+------------+
| nl       | validation |
+----------+------------+
There are 4 missing entries:
+----------+------------+----------+---------+
| Language | Namespace  | Entry    | Error   |
+----------+------------+----------+---------+
| nl       | pagination | previous | Missing |
| nl       | pagination | next     | Missing |
| en       | passwords  | sent     | Empty   |
| nl       | passwords  | token    | Missing |
+----------+------------+----------+---------+
Finished with 5 errors
```

# Still todo...

- Adding support for deeply nested arrays
- Crosschecking parameters and pluralizations
- Add ready-to-use unittesting possibilities
- Add more comments in the sourcecode...
- Add support for vendor languagefiles