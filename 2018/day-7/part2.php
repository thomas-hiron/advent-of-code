<?php
	$handle = fopen("input.txt", "r");

	$steps = [];
	$requirements = [];
    while (($line = fgets($handle)) !== false) {
    	$stepName = preg_replace('/Step ([A-Z]).+/', '$1', $line);
    	$stepRequirement = preg_replace('/.+step ([A-Z]).+/', '$1', $line);

    	$steps[] = trim($stepName);
    	$steps[] = trim($stepRequirement);
    	$requirements[] = trim($line);
    }

    fclose($handle);

    $WORKER_NUMBER = 5;
    $STEP_DURATION = 60;

    $workers = [];
    for ($i = 0 ; $i < $WORKER_NUMBER ; ++$i) {
    	$workers[] = [
    		'workingStep' => null,
    		'stepEndingAt' => null,
    	];
    }

    $steps = array_unique($steps);
    sort($steps);

    $stepsDone = array_fill_keys($steps, false);

    // While all steps aren't done
    $seconds = 0;
    while (in_array(false, array_values($stepsDone))) {	  
	    $canBegin = $steps;
	    foreach ($steps as $key => $step) {
	    	foreach ($requirements as $requirement) {
	    		// Can't begin or done, continue
	    		if (!in_array($step, $canBegin) || $stepsDone[$step] === true) {
	    			unset ($canBegin[$key]);
	    			continue;
	    		}

	    		if (preg_match("/$step can begin/", $requirement)) {
	    			$stepRequired = preg_replace('/Step ([A-Z]).+/', '$1', $requirement);
	    			
	    			// Step can't begin because required step isn't done
	    			if (!$stepsDone[$stepRequired]) {
	    				unset ($canBegin[$key]);
	    			}
	    		}
	    	}
	    }

	    // Assigned ready tasks
	    while (count($canBegin)) {

		    $stepToDo = array_shift($canBegin);

		    // Ensure not already assigned
		    for ($i = 0 ; $i < $WORKER_NUMBER ; ++$i) {
		    	if ($workers[$i]['workingStep'] === $stepToDo) {
		    		continue 2;
		    	}
		    }

		    // Assign worker
		    for ($i = 0 ; $i < $WORKER_NUMBER ; ++$i) {
		    	if ($workers[$i]['workingStep'] === null) {
		    		$workers[$i] = [
			    		'workingStep' => $stepToDo,
			    		'stepEndingAt' => $seconds + $STEP_DURATION + ord($stepToDo) - 64,		    			
		    		];

		    		break;
		    	}
		    }
	    }

	    ++$seconds;

    	// Check done tasks
	    for ($i = 0 ; $i < $WORKER_NUMBER ; ++$i) {
	    	if ($workers[$i]['stepEndingAt'] === $seconds) {
	    		// Set task to done
	    		$stepsDone[$workers[$i]['workingStep']] = true;

	    		// Free worker
	    		$workers[$i]['workingStep'] = null;
	    	}
	    }
    }

    echo $seconds;