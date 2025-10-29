<?php
require 'timbthumb.php';

// Fake the query string
//$_SERVER['QUERY_STRING'] = 'src=path/to/src/image.jpg&w=200&h=150';
parse_str($_SERVER['QUERY_STRING'], $_GET);
//echo $_SERVER['QUERY_STRING'];
// When instantiated, timthumb will generate some properties: 
// salt, directories, cachefile, etc.
$t = new timthumb();

// Get the cache file name
$f = $t->getCacheFile();

// Delete the file
if (file_exists($f)) {
	echo 'YES';
    unlink($f);
}
///echo 'NO';