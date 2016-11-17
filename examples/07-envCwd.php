#!/usr/bin/env php
<?php
require_once "../Process.php";

use Hypnopompia\Process;

$process = Process::factory("./envcwd.sh", [
	'cwd' => getcwd() . '/scripts/', // The initial working dir for the command. This must be an absolute directory path.
	'env' => [
		'FOO' => 'BAR',
	],
]);

$process->start()->join()->stop(); // Start the process and wait for it to end, then cleanup
extract($process->getOutput());

echo trim($stdout) . "\n";
echo "Exit code: " . $process->getExitcode() . "\n";
