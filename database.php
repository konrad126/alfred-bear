<?php
require_once 'helper.php';

const BEAR_DB_FILE_PATH = '/Users/zvonimir/Library/Containers/net.shinyfrog.bear/Data/Documents/Application Data/database.sqlite';

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
    $query = 'SELECT Z_PK ,Z_ENT, Z_OPT, ZMODIFICATIONDATE, ZTITLE FROM ZSFNOTETAG';

    $tag = array_shift($tags);
    $query .= " WHERE ( ZTITLE LIKE '%" . $tag . "%'";
    // if more than one tag
    foreach ($tags as $tag) {
        $query .= " OR ZTITLE LIKE '%" . $tag . "%'";
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
