<?php

/**
 * @param $input
 * @return array
 */
function tokenizeInput($input)
{
    // remove extra whitespaces
    $input = preg_replace('/\h+/', ' ', $input);
    return explode(' ', trim($input));
}


function formatNoteResult($result)
{
    $alfredResults = [];
    while ($resItem = $result->fetchArray(SQLITE3_ASSOC)) {
        $alfredResults['items'][] = [
            'title' => $resItem['ZTITLE'],
            'uuid' => $resItem['ZUNIQUEIDENTIFIER'],
            'arg' => $resItem['ZUNIQUEIDENTIFIER'],
            'subtitle' => $resItem['ZSUBTITLE'],
        ];
    }
    return json_encode($alfredResults);
}


function formatTagResult($result)
{
    $alfredResults = [];
    while ($resItem = $result->fetchArray(SQLITE3_ASSOC)) {
        $alfredResults['items'][] = [
            'title' => $resItem['ZTITLE'],
            'uuid' => $resItem['ZTITLE'],
            'arg' => $resItem['ZTITLE'],
        ];
    }
    return json_encode($alfredResults);
}




