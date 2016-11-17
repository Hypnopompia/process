#!/usr/bin/env php
<?php
require_once "../Process.php";

use Hypnopompia\Process;

$process = Process::factory("./scripts/simple.sh");
$process->start()->join(); // Start the process and wait for it to end
extract($process->getOutput());

if (mb_strlen($stdout) > 0) {
	echo "[" . $process->getPid() . "] " . trim($stdout) . "\n";
}

if (mb_strlen($stderr) > 0) {
	echo "[" . $process->getPid() . "] " . "ERROR: " . trim($stderr) . "\n";
}

$process->stop();
echo "Exit code: " . $process->getExitcode() . "\n";
