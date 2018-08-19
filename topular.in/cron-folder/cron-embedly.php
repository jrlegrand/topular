<?php
// Set time zone
date_default_timezone_set('America/New_York');

// Make unlimited execution time
ini_set('max_execution_time', 0);
ini_set('memory_limit', '2056M');

// Start counting time for the page load
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];

// Make the connection
$dbc = @mysqli_connect ('localhost', 'root', 'password', 'topular_test') or die ('Could not connect to MySQL server');
//$dbc = @mysqli_connect ('localhost', 'root', 'password', 'social') or die ('Could not connect to MySQL server');

// Set the encoding
mysqli_set_charset($dbc, 'utf8');

$q = "SELECT * FROM article WHERE DATE(date_published) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()";
$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />mySQL error: " . mysqli_error($dbc));
$i = 0;

while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

$url = $row['url'];
$embedly_request_url = 'http://api.embed.ly/1/oembed?key=0c988c68a8294cb8addc1d01a45346f7&url=' . $url;
$json = file_get_contents($embedly_request_url);
$objects = json_decode($json);

$embedly_image = $objects->thumbnail_url;
echo $embedly_image . "<br>";

}

// Calculate time it took for page load
$mtime = explode(' ', microtime());
$time = round($mtime[0] + $mtime[1] - $starttime, 3);

echo 'Count: ' . $i . ' Time: ' . $time;