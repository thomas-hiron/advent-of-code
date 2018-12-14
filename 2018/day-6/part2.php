<?php
    $handle = fopen("input.txt", "r");

    $coords = [];
    while (($line = fgets($handle)) !== false) {
        $explodedCoords = explode(', ', $line);
        $coords[] = [
            'x' => (int) $explodedCoords[0],
            'y' => (int) $explodedCoords[1],
        ];
    }

    // Calc max x and y
    $maxX = $maxY = 0;
    foreach ($coords as $coord) {
        $maxX = max($maxX, $coord['x']);
        $maxY = max($maxY, $coord['y']);
    }

    // Create grid
    $grid = [];
    for ($i = 0 ; $i <= $maxY ; ++$i) {
        for ($j = 0 ; $j <= $maxX + 1 ; ++$j) {
            $grid[$i][$j] = '.';
        }
    }

    // Add coords
    foreach ($coords as $key => $coord) {
        $grid[$coord['y']][$coord['x']] = $key;
    }

    // Calc nearest point
    foreach ($grid as $y => $row) {
        foreach ($row as $x => $col) {
            $totalDistance = 0;
            foreach ($coords as $key => $coord) {
                $abs = abs($x - $coord['x']) + abs($y - $coord['y']);

                $totalDistance += $abs;
            }

            if ($totalDistance < 10000) {
            	$grid[$y][$x] = '#';
            }
        }
    }

    $total = 0;
    foreach ($grid as $y => $row) {
        foreach ($row as $x => $col) {
        	if ($grid[$y][$x] === '#') {
        		++$total;
        	}
        }
    }

    echo $total;
    
    fclose($handle);
