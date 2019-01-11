<?php
    $numbersList = file_get_contents("input.txt");

    $numbers = explode(" ", $numbersList);

    $metaDataEntries = getMetadataEntries(0, $numbers)['metadata-entries'];
    echo array_sum($metaDataEntries);

    function getMetadataEntries (int $index, array $numbers) 
    {
    	$childrenNumber = (int) $numbers[$index];
    	$metaDataEntriesNumber = (int) $numbers[$index + 1];
    	$metaDataEntries = [];

    	// Move index
    	$index += 2;

    	if ($childrenNumber === 0) {
    		for ($i = 0 ; $i < $metaDataEntriesNumber ; ++$i) {
    			$metaDataEntries[] = (int) $numbers[$index + $i];
    		}

    		return [
    			"end-index" => $index + $i,
    			"metadata-entries" => $metaDataEntries,
    		];
    	}

    	for ($i = 0 ; $i < $childrenNumber ; ++$i) {
    		$childData = getMetadataEntries ($index, $numbers);
    		$index = $childData["end-index"];
    		$metaDataEntries = array_merge($metaDataEntries, $childData["metadata-entries"]);
    	}

    	for ($i = 0 ; $i < $metaDataEntriesNumber ; ++$i) {
    		$metaDataEntries[] = (int) $numbers[$index + $i];
    	}

		return [
			"end-index" => $index + $i,
			"metadata-entries" => $metaDataEntries,
		];
    }