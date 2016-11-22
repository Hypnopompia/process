#!/usr/bin/env php
<?php
require_once "../Process.php";

use Hypnopompia\Process;

$totalProcesses = 5000;
$concurrentProcesses = 20;
$processesRan = 0;
$processes = [];

while ($processesRan < $totalProcesses) {
	// Start new processes until we have $totallProcesses running
	while (count($processes) < $concurrentProcesses && $processesRan < $totalProcesses) {
		$process = Process::factory("curl -s http://localhost/?t=" . $processesRan);
		$process->useSTDERR(false);
		$process->storeSTDOUT(false);
		$process->storeSTDERR(false);
		$process->start();
		echo "[" . $process->getPid() . "] started - " . $process->getCommand() . "\n";

		$processes[$process->getPid()] = $process;
		$processesRan++;
	}

	echo $processesRan . " total processes started.\n";
	usleep(500 * 1000); // half a second

	// Check for any processes that have finished and clear them out of the list.
	foreach ($processes as $pid => $process) {
		$process->update();

		if (!$process->running()) {
			echo "[" . $pid . "] finished with exit code " . $process->getExitcode()
			. " in " . number_format($process->getRunTime(), 3) . " seconds.\n";

			$process->stop();
			unset($processes[$pid]);
		}
	}
}

echo "All processes finished.\n";