<?php
	$handle = fopen("input.txt", "r");
    $polymer = fgets($handle);
    fclose($handle);

    $alphabet = range('a', 'z');
    $minLength = strlen($polymer);
    foreach ($alphabet as $letter) {
    	$newPolymer = preg_replace("/$letter/i", '', $polymer);
	    while (true) {
	        $reacted = false;

	        for ($i = 0, $l = strlen($newPolymer) - 1 ; $i < $l ; ++$i) {
	            if (abs(ord($newPolymer[$i]) - ord($newPolymer[$i+1])) === 32) {
	                $newPolymer = substr_replace($newPolymer, '', $i, 2);
	                $l -= 2;
	                $reacted = true;
	            }
	        }

	        if (!$reacted) {
	            break;
	        }
	    }

	    $minLength = min(strlen($newPolymer), $minLength);
    }

    echo $minLength;