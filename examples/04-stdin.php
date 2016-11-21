#!/usr/bin/env php
<?php
require_once "../Process.php";

use Hypnopompia\Process;

$process = Process::factory("php");
$process->useStdin(true);
$process->start();

$process->send("<?php echo 'hello world'; file_put_contents('php://stderr', 'my error'); ?>", true); // Close Stdin after sending so php will execute the script
$process->join(); // Wait for the process to end

extract($process->getOutput());

if (mb_strlen($stdout) > 0) {
	echo "[" . $process->getPid() . "] " . trim($stdout) . "\n";
}

if (mb_strlen($stderr) > 0) {
	echo "[" . $process->getPid() . "] " . "ERROR: " . trim($stderr) . "\n";
}

$process->stop();
echo "Run Time: " . $process->getRunTime() . " seconds\n";
echo "Exit code: " . $process->getExitcode() . "\n";
