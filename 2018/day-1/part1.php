<?php
	$handle = fopen("input.txt", "r");
	$frequency = 0;
    while (($line = fgets($handle)) !== false) {
    	$frequency += intval($line);
    }

    fclose($handle);

    echo $frequency;
