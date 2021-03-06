<?php
require_once 'helper.php';

function searchNotes($searchTerms)
{
    $query = generateNotesQuery(tokenizeInput($searchTerms));
    return formatNoteResult(executeQuery($query));
}

function searchTagLists($listNames)
{
    $query = generateTagListQuery(tokenizeInput($listNames));
    return formatTagResult(executeQuery($query));
}

function generateTagListQuery($tags)
{
    $query = 'select distinct ZSFNOTETAG.ZTITLE, ZSFNOTETAG.Z_PK from ZSFNOTE join Z_5TAGS on Z_5TAGS.Z_5NOTES = ZSFNOTE.Z_PK join ZSFNOTETAG on ZSFNOTETAG.Z_PK = Z_5TAGS.Z_10TAGS where ZSFNOTE.ZTRASHED = 0';

    $tag = array_shift($tags);
    $query .= " AND ( ZSFNOTETAG.ZTITLE LIKE '%" . $tag . "%'";
    // if more than one tag
    foreach ($tags as $tag) {
        $query .= " OR ZSFNOTETAG.ZTITLE LIKE '%" . $tag . "%'";
    }

    return $query . ')';

}


function generateNotesQuery($titles)
{
    $query = 'SELECT DISTINCT ZSFNOTE.ZTITLE,ZUNIQUEIDENTIFIER,ZSUBTITLE FROM  ZSFNOTE WHERE ZTRASHED = 0';

    $title = array_shift($titles);
    $query .= " AND ( ZSFNOTE.ZTITLE LIKE '%" . trim($title) . "%'";

    foreach ($titles as $title) {
        $query .= " OR ZSFNOTE.ZTITLE LIKE '%" . trim($title) . "%'";
    }

    return $query . ')';
}


/**
 * @param $query
 * @return SQLite3Result
 */
function executeQuery($query)
{
    $bearDatabasePath = getenv('db_path');

    $sqlite = new SQLite3($bearDatabasePath, SQLITE3_OPEN_READONLY);
    return $sqlite->query($query);
}
