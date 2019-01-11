<?php
    $numbersList = file_get_contents("input.txt");

    $numbers = explode(" ", $numbersList);

    $metaDataEntries = getMetadataEntries(0, $numbers);
    echo $metaDataEntries["value"];

    function getMetadataEntries (int $index, array $numbers) 
    {
    	$childrenNumber = (int) $numbers[$index];
    	$metaDataEntriesNumber = (int) $numbers[$index + 1];
        $childrenValues = [];
        $value = 0;

    	// Move index
    	$index += 2;

    	if ($childrenNumber === 0) {
    		for ($i = 0 ; $i < $metaDataEntriesNumber ; ++$i) {
    			$value += (int) $numbers[$index + $i];
    		}

    		return [
    			"end-index" => $index + $i,
                "value" => $value,
    		];
    	}

    	for ($i = 0 ; $i < $childrenNumber ; ++$i) {
    		$childData = getMetadataEntries ($index, $numbers);
    		$index = $childData["end-index"];

            $childrenValues[$i + 1] = $childData["value"];
    	}

    	for ($i = 0 ; $i < $metaDataEntriesNumber ; ++$i) {
    		$metaDataValue = (int) $numbers[$index + $i];

            $value += $childrenValues[$metaDataValue] ?? 0;
    	}

		return [
			"end-index" => $index + $i,
            "value" => $value,
		];
    }