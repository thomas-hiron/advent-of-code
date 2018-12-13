<?php
    $handle = fopen("input.txt", "r");

    while (($line = fgets($handle)) !== false) {
        $ids[] = trim($line);
    }

    foreach ($ids as $id) {
        checkDiff($ids, $id);
    }

    fclose($handle);


    function checkDiff (array $ids, string $id)
    {
        $idSplit = str_split($id);
        $differentLetterPosition = null;
        foreach ($ids as $id) {
            $differentLetters = 0;
            $otherIdSplit = str_split($id);

            for ($i = 0, $l = count($idSplit) ; $i < $l ; ++$i) {
                if ($idSplit[$i] !== $otherIdSplit[$i]) {
                    ++$differentLetters;
                    $differentLetterPosition = $i;
                }
            }

            if ($differentLetters === 1) {
                exit (substr_replace($id, '', $differentLetterPosition, 1));
            }
        }
    }