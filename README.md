Process
=====

Process is a PHP library to help with the task of running other applications asynchronously from PHP in a pseudo-threaded way.

Highlights
-------

Installation
-------
Installing with composer is recommended.
```sh
composer require hypnopompia/process
```


Documentation
-------
Be sure to checkout the examples folder.

```php
<?php
require "vendor/autoload.php";
use Hypnopompia\Process;
$process = Process::factory("./scripts/simple.sh");
$process->start()->join()->stop(); // Start the process and wait for it to end, then cleanup
extract($process->getOutput());
echo "Process Id: " . $process->getPid() . "\n";
echo "STDOUT: " . $stdout . "\n";
echo "STDERR: " . $stderr . "\n";
echo "Exit code: " . $process->getExitcode() . "\n";
```