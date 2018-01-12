<?php
	// duet
	// https://adventofcode.com/2017/day/18
	$input = file("input.txt", FILE_IGNORE_NEW_LINES);

	$variables = [];
	$sound = 0;
	for ($i = 0, $l = count($input); $i < $l; ++$i) {
		$parts = explode(' ', $input[$i]);
		$instructionType = $parts[0];
		$varName = $parts[1];
		$value = $parts[2] ?? null;

		// Set if not exist
		if(!isset($variables[$varName])) {
			$variables[$varName] = 0;
		}

		// If registry name, change to its value
		if(isset($variables[$value])) {
			$value = $variables[$value] ?? 0;
		}

		switch($instructionType) {
			case "snd":
				$sound = $variables[$varName];

				break;
			case "set":
				$variables[$varName] = $value;

				break;
			case "add":
				$variables[$varName] += $value;

				break;
			case "mul":
				$variables[$varName] *= $value;

				break;
			case "mod":
					$variables[$varName] = $variables[$varName] % $value;

				break;
			case "rcv":
				if($variables[$varName] !== 0) {
					echo "recovered value: ".$sound;
					break 2;
				}

				break;
			case "jgz":
				if($variables[$varName] > 0) {
					$i += $value - 1;
				}

				break;
		}
	}
