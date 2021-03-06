#!/usr/bin/env php
<?php
require_once "../Process.php";

use Hypnopompia\Process;
use Hypnopompia\ProcessStartFailedException;

$processCount = 5000;
$processes = [];

for ($i = 0; $i < $processCount; $i++) {
	$process = Process::factory("./scripts/simple.sh " . $i);
	$process->useSTDERR(false);
	$process->storeSTDOUT(false);
	$process->storeSTDERR(false);
	try {
		$process->start();
	} catch (ProcessStartFailedException $e) {
		echo "Couldn't start process. Probably too many open pipes.\n";
		break;
	}

	echo "Started $i - " . $process->getPid() . "\n";

	$processes[$process->getPid()] = $process;
}

$running = true;
while ($running) {
	$running = false;
	foreach ($processes as $pid => $process) {
		extract($process->update());

		if (mb_strlen($stdout) > 0) {
			echo "[" . $process->getPid() . "] " . trim($stdout) . "\n";
		}

		if (mb_strlen($stderr) > 0) {
			echo "[" . $process->getPid() . "] " . "ERROR: " . trim($stderr) . "\n";
		}

		if ($process->running()) {
			$running = true;
		} else {
			echo "[" . $pid . "] finished with exit code " . $process->getExitcode() . " in " . number_format($process->getRunTime(), 3) . " seconds.\n";

			$process->stop();
			unset($processes[$pid]);
		}
	}
	sleep(1);
}

echo "All processes finished.\n";