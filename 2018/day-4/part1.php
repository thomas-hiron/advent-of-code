<?php
	$handle = fopen("input.txt", "r");

	$events = [];
    while (($line = fgets($handle)) !== false) {
    	$time = preg_replace('/\].+/', ']', $line);
    	$time = preg_replace('/[!\\D]/', '', $time);

    	$action = trim(preg_replace('/.+\] /', '', $line));

		$events[$time] = $action;
    }

    fclose($handle);
    
    ksort($events);

    $guards = [];
    $guardId =
    $fallsAsleepTime = 
    $wakesUpTime = null;
    
    // Fill sleeping time
    foreach ($events as $time => $action) {
    	if (strpos($action, 'Guard') === 0) {
    		$guardId = preg_replace('/.+#([0-9]+).+/', '$1', $action);

    		if (!isset($guards[$guardId])) {
    			$guards[$guardId] = [
    				'totalSleepingTime' => 0,
    				'minutes' => array_fill_keys(range(0, 59), 0),
    			];
    		}
    	}
    	else if ($action === 'falls asleep') {
    		$fallsAsleepTime = (int) substr($time, -2);
    	}
    	// Wakes up
    	else {
    		$wakesUpTime = (int) substr($time, -2);
    		$guards[$guardId]['totalSleepingTime'] += $wakesUpTime - $fallsAsleepTime;

    		for ($i = $fallsAsleepTime ; $i < $wakesUpTime ; ++$i) {
    			++$guards[$guardId]['minutes'][$i];
    		}
    	}
    }

    // Calc guard most asleep
    $mostAsleepGuard = null;
    $mostTimeAsleep = 0;
    foreach ($guards as $guardId => $guard) {
    	if ($guard['totalSleepingTime'] > $mostTimeAsleep) {
    		$mostTimeAsleep = $guard['totalSleepingTime'];
    		$mostAsleepGuard = $guardId;
    	}
    }

    // Calc minute most asleep
    $minuteMostAsleep = null;
    $maxAsleepTimes = 0;
    foreach ($guards[$mostAsleepGuard]['minutes'] as $minute => $numberTimesAsleep) {
    	if ($numberTimesAsleep > $maxAsleepTimes) {
    		$maxAsleepTimes = $numberTimesAsleep;
    		$minuteMostAsleep = $minute;
    	}
    }

    echo $mostAsleepGuard * $minuteMostAsleep;
    
