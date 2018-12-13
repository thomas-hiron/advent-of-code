<?php
    $handle = fopen("input.txt", "r");

    $claims = [];
    while (($line = fgets($handle)) !== false) {
    	$claims[] = [
    		"id" => intval(preg_replace('/^#([0-9]+) .+$/', '$1', $line)),
    		"left" => intval(preg_replace('/.+ @ ([0-9]+),.+$/', '$1', $line)),
    		"top" => intval(preg_replace('/^.+,([0-9]+):.+$/', '$1', $line)),
    		"width" => intval(preg_replace('/^.+: ([0-9]+)x.+$/', '$1', $line)),
    		"height" => intval(preg_replace('/^.+x([0-9]+)$/', '$1', $line)),
    	];
    }

    // Calc width and height of area
    $width = 0;
    $height = 0;
    foreach ($claims as $claim) {
    	$width = max($width, $claim["left"] + $claim["width"]);
    	$height = max($height, $claim["top"] + $claim["height"]);
    }

    // Create area
    $area = [];
    for ($i = 0 ; $i < $height ; ++$i) {
    	for ($k = 0 ; $k < $width ; ++$k) {
    		$area[$i][$k] = '.';
    	}
    }

    // Fill with claims
	$overlappingInches = [];
    foreach ($claims as $claim) {
	    for ($i = $claim["top"] ; $i < $claim["top"] + $claim["height"] ; ++$i) {
	    	for ($k = $claim["left"] ; $k < $claim["left"] + $claim["width"] ; ++$k) {
	    		if ($area[$i][$k] === '.') {
	    			$area[$i][$k] = '#';
	    		}
	    		else {
	    			$overlappingInches[] = $i.'-'.$k;
	    		}
	    	}
	    }
    }

    echo count(array_unique($overlappingInches));

    fclose($handle);