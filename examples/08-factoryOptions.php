#!/usr/bin/env php
<?php
require_once "../Process.php";

use Hypnopompia\Process;

$process = Process::factory("./envcwd.sh", [
	'cwd' => getcwd() . '/scripts/', // The initial working dir for the command. This must be an absolute directory path.
	'env' => [
		'FOO' => 'BAR',
	],
	'useSTDIN' => false,
	'useSTDOUT' => true,
	'useSTDERR' => true,
	'storeSTDOUT' => true,
	'storeSTDERR' => true,
	'timeout' => null, // Seconds to wait before timing out and killing the process (floating point is acceptable eg: 0.5 for half a second)
	'sleeptime' => 100, // milliseconds to sleep between loops while waiting for the process to finish ( $process->join() )
]);

$process->start()->join()->stop(); // Start the process and wait for it to end, then cleanup
extract($process->getOutput());

echo trim($stdout) . "\n";
echo "Run Time: " . $process->getRunTime() . " seconds\n";
echo "Exit code: " . $process->getExitcode() . "\n";
