<?php
	$handle = fopen("input.txt", "r");
    $polymer = fgets($handle);
    fclose($handle);

    while (true) {
        $reacted = false;

        for ($i = 0, $l = strlen($polymer) - 1 ; $i < $l ; ++$i) {
            if (abs(ord($polymer[$i]) - ord($polymer[$i+1])) === 32) {
                $polymer = substr_replace($polymer, '', $i, 2);
                $l -= 2;
                $reacted = true;
            }
        }

        if (!$reacted) {
            break;
        }
    }

    echo strlen($polymer);