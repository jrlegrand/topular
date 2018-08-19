<?php
include('cron-header.php');

$q = "SELECT * FROM article WHERE DATE(date_published) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()";
$r = mysqli_query($dbc, $q);
$i = 0;

while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

	// Assign variables from database
	$url = $row['url'];
	$article_id = $row['id'];
	
	// Get API JSON data
	$request_url = 'http://www.linkedin.com/countserv/count/share?url=' . $url . '&format=json';
	$json = file_get_contents($request_url);
	$result = json_decode($json);
	
	// Assign data to a variable
	$shares = $result->count;

	// Update database
	$a = "UPDATE article SET linkedin_shares='$shares' WHERE id='$article_id' LIMIT 1";
	$b = mysqli_query($dbc, $a);
	
	echo $shares . ' - ' . $url . '<br>';
	$i++;

}

// Calculate time it took for page load
$mtime = explode(' ', microtime());
$time = round($mtime[0] + $mtime[1] - $starttime, 3);

echo 'Count: ' . $i . ' Time: ' . $time;

include('cron-score.php');