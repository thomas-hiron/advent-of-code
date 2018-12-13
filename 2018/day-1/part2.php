<?php
	$handle = fopen("input.txt", "r");
	$frequency = 0;
	$frequencies = [0];

	while (true) {
	    while (($line = fgets($handle)) !== false) {
	    	$frequency += intval($line);

	    	if (in_array($frequency, $frequencies)) {
	    		echo $frequency;
	    		exit;
	    	}

	    	$frequencies[] = $frequency;
	    }
	    rewind($handle);
	}

    fclose($handle);