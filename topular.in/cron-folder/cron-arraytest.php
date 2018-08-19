<?php
include('cron-header.php');

$q = "SELECT id, feed_url FROM source ORDER BY id DESC";
$r = mysqli_query($dbc, $q);

$feed_list = array();
	
// Query database for all sources and return source ID and URL
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$feed_list[$row['id']] = $row['feed_url'];
	echo $row['feed_url'] . '<br>';
}

$q = "SELECT id, url FROM article ORDER BY id DESC";
$r = mysqli_query($dbc, $q);

$article_list = array();

// Make an array of all article URLs and use article ID's as keys
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$article_list[$row['id']] = $row['url'];
}

$fake_array = array(
	'http://www.chicagotribune.com/sports/rss2.0.xml?#',
	'http://www.ogdenonpolitics.com/feeds/posts/default?#',
	'http://indyarts.org/gallery-924?format=feed&type=rss',
	);

foreach ($fake_array as $f) {

	$source_id = array_search($f, $feed_list);
	if ($source_id) echo '<p>YES!' . $f . '</p>';
	
}

// Calculate time it took for page load
$mtime = explode(' ', microtime());
$time = round($mtime[0] + $mtime[1] - $starttime, 3);

// Output results
echo 'Time: ' . $time . 's';
