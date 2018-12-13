<?php
    $handle = fopen("input.txt", "r");

	$alphabet = range('a', 'z');
	$twoTimesCount = 0;
	$threeTimesCount = 0;

    while (($line = fgets($handle)) !== false) {
    	$appearTwoTimes = false;
    	$appearThreeTimes = false;
    	foreach ($alphabet as $letter) {
    		$letterCount = substr_count($line, $letter);

    		if ($letterCount === 2 && !$appearTwoTimes) {
    			++$twoTimesCount;
    			$appearTwoTimes = true;
    		}
    		else if ($letterCount === 3 && !$appearThreeTimes) {
    			++$threeTimesCount;
    			$appearThreeTimes = true;
    		}
    	}
    }

    echo $twoTimesCount * $threeTimesCount;

    fclose($handle);