 
<?php
	// spinlock part 1
	// https://adventofcode.com/2017/day/17
	$inputSteps = file_get_contents("input.txt");
	$curPos = 0;
	$values = [0];

	for($i = 1 ; $i <= 2017 ; ++$i) {
		$curPos = ($curPos + $inputSteps) % $i + 1;
		array_splice($values, $curPos, 0, [$i]);
	}

	echo "result is: ".$values[$curPos + 1];