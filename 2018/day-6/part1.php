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
            $distances = [];
            foreach ($coords as $key => $coord) {
                $abs = abs($x - $coord['x']) + abs($y - $coord['y']);

                $distances[$key] = $abs;
            }

            // Sort keeping keys
            asort($distances);

            $previousDistance = null;
            $key = key($distances);
            foreach ($distances as $distance) {
                if ($previousDistance === null) {
                    $previousDistance = $distance;
                    continue;                    
                }

                if ($previousDistance !== $distance) {
                    $grid[$y][$x] = $key;
                }

                break;
            }
        }
    }

    // Get infinite values
    $infiniteValues = [];
    foreach ($grid as $y => $row) {
        foreach ($row as $x => $col) {
            if ($x === 0 || $x === $maxX + 1 || $y === 0 || $y === $maxY) {
                $infiniteValues[] = $grid[$y][$x];
            }
        }
    }

    // Count non infinite values
    $finiteValues = [];
    foreach ($grid as $y => $row) {
        foreach ($row as $x => $col) {
            if (in_array($grid[$y][$x], $infiniteValues)) {
                continue;
            }

            if (!isset($finiteValues[$grid[$y][$x]])) {
                $finiteValues[$grid[$y][$x]] = 0;
            }

            ++$finiteValues[$grid[$y][$x]];
        }
    }

    echo max(array_values($finiteValues));
    
    fclose($handle);
