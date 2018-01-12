 
<?php
	// spinlock part 2
	// https://adventofcode.com/2017/day/17
	$inputSteps = file_get_contents("input.txt");
	$curPos = 0;
	$value = 0;

	for($i = 1 ; $i <= 50000000 ; ++$i) {
		if(1 === $curPos = ($curPos + $inputSteps) % $i + 1) {
			$value = $i;
		}
	}

	echo "result is: ".$value;