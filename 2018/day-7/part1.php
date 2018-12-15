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

    $steps = array_unique($steps);
    sort($steps);

    $stepsDone = array_fill_keys($steps, false);

    // While all steps aren't done
    $stepsOrder = null;
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

	    $stepToDo = array_shift($canBegin);

	    // Set done
	    $stepsDone[$stepToDo] = true;

	    // Output result
	    $stepsOrder .= $stepToDo;
    }

    echo $stepsOrder;