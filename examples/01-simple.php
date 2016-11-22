#!/usr/bin/env php
<?php
require_once "../Process.php";

use Hypnopompia\Process;

$process = Process::factory("./scripts/simple.sh");
$process->storeSTDOUT(false);
$process->storeSTDERR(false);
$process->start();
$process->start();

while ($process->running()) {
	extract($process->update());

	if (mb_strlen($stdout) > 0) {
		echo "[" . $process->getPid() . "] " . trim($stdout) . "\n";
	}

	if (mb_strlen($stderr) > 0) {
		echo "[" . $process->getPid() . "] " . "ERROR: " . trim($stderr) . "\n";
	}
}

$process->stop();
echo "Run Time: " . $process->getRunTime() . " seconds\n";
echo "Exit code: " . $process->getExitcode() . "\n";
