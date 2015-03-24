<?php

	$output = shell_exec('crontab -l');
	echo "output: " . $output;
	
	$cron_file = "nlist_cron";
	$handler = fopen($cron_file, 'w') or die("Cron setup failed; permission denied.");
	fclose($handler);
	
	echo "done";