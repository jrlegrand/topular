<?php
include('cron-header.php');

$q = "SELECT * FROM article WHERE DATE(date_published) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()";
$r = mysqli_query($dbc, $q);
$i = 0;

while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	
	if (empty($row['bitly_url'])) {
	
		// Assign variables from database
		$url = urlencode($row['url']);
		$article_id = $row['id'];

		$api_key = '7cd7cdba2f15ca80bdf942c5165eae566ea0928c';
		$request_url = 'https://api-ssl.bitly.com/v3/shorten?access_token=' . $api_key . '&longUrl=' . $url;
		$json = file_get_contents($request_url);
		$result = json_decode($json);
		
		$bitly_url = $result->data->url;

		// Update database
		$a = "UPDATE article SET bitly_url='$bitly_url' WHERE id='$article_id' LIMIT 1";
		$b = mysqli_query($dbc, $a);

		echo $bitly_url . '<br>';
		$i++;

	}
	
}

// Calculate time it took for page load
$mtime = explode(' ', microtime());
$time = round($mtime[0] + $mtime[1] - $starttime, 3);

echo 'Count: ' . $i . ' Time: ' . $time;