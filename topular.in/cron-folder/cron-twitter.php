<?php
include('cron-header.php');

//if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id']))
//$q = "SELECT * FROM article WHERE source_id=692";
//else
$q = "SELECT * FROM article WHERE DATE(date_published) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()";
$r = mysqli_query($dbc, $q);
$i = 0;

while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	
	// Assign variables from database
	$url = $row['url'];
	$article_id = $row['id'];
	
	// Get API JSON data
	$request_url = 'http://urls.api.twitter.com/1/urls/count.json?url=' . $url;
	$json = file_get_contents($request_url);
	$result = json_decode($json);
	
	// Assign data to a variable
	$retweets = $result->count;
	
	// Update database
	$a = "UPDATE article SET retweets='$retweets' WHERE id='$article_id' LIMIT 1";
	$b = mysqli_query($dbc, $a) or trigger_error("Query: $a\n<br />mySQL error: " . mysqli_error($dbc));

	echo $retweets . ' - ' . $url . '<br>';
	$i++;

}

// Calculate time it took for page load
$mtime = explode(' ', microtime());
$time = round($mtime[0] + $mtime[1] - $starttime, 3);

echo 'Count: ' . $i . ' Time: ' . $time;

include('cron-score.php');