#!/usr/bin/env php
<?php
require_once "../Process.php";

use Hypnopompia\Process;

$process = Process::factory("./scripts/echo.sh");
$process->storeSTDOUT(false);
$process->storeSTDERR(false);
$process->useStdin(true);
$process->start();

$i = 0;
while ($process->running() && $i++ <= 10) {
	$process->send("Talk to me " . $i . "\n");
	extract($process->update());

	if (mb_strlen($stdout) > 0) {
		echo "[" . $process->getPid() . "] " . trim($stdout) . "\n";
	}

	if (mb_strlen($stderr) > 0) {
		echo "[" . $process->getPid() . "] " . "ERROR: " . trim($stderr) . "\n";
	}

	sleep(1);
}

$process->stop();
echo "Run Time: " . $process->getRunTime() . " seconds\n";
echo "Exit code: " . $process->getExitcode() . "\n";
