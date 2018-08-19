<?php
include('cron-header.php');

$q = "SELECT * FROM article ORDER BY timestamp DESC";
$r = mysqli_query($dbc, $q);
$i = 0;

while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	
	$article_id = $row['id'];
	
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// ###############################
	// Score and trend logging
	// ###############################

	$score = $row['fb_likes'] + $row['fb_shares'] + $row['retweets'] + $row['linkedin_shares'];
	
	// Calculate trend between current score and score one hour ago
	// ********************************************
	// Soon change this to calculate rolling average if an article has
	// at least 3 entries in the data table
	// ********************************************
	$trend = $score - $row['score'];	
	
	// Update the article's score and trend in the database
	$a = "UPDATE article SET score='$score', trend='$trend' WHERE id='$article_id' LIMIT 1";
	$b = mysqli_query($dbc, $a);
	
	// ###############################
	// End score and trend logging
	// ###############################
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// ###############################
	// Data logging
	// ###############################
	
	// Set age as the difference in days between now and the initial time stamp
	$age = floor( abs(time() - strtotime($row['timestamp'])) / (60*60*24) );
	
	// If article is less than 1 day old, calculate how many hours old it is
	$data = false;
	if ($age < 1) {
		// Calculate number of hours since last timestamp if article is less than 1 day old
		// If article is one hour older than last timestamp, make a new data entry
		$hours = abs(time() - strtotime($row['timestamp']) / (60*60));
		if ($hours > 1) $data = true;
	
	// If article is one day older than last timestamp, make a new data entry
	} else if ($age > $row['age']) {
		$data = true;
	}
	
	// If article is older than 3 days, don't make a data entry
	if ($age > 3) $data = false;	
	
	// If it is appropriate, make a new data entry in data table
	if ($data) {
		$a = "INSERT INTO data (article_id, fb_likes, fb_shares, retweets, linkedin_shares, score, rank, age) ";
		$a .= "VALUES ('$article_id', '{$row['fb_likes']}', '{$row['fb_shares']}', '{$row['retweets']}', '{$row['linkedin_shares']}', '$score', '{$row['rank']}', '$age')";
		$b = mysqli_query($dbc, $a);
	}			
	// ###############################
	// End data logging
	// ###############################
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
	$i++;
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// ###############################
// Top 10 image logging
// ###############################

// Get top 100 articles for the day FOR EACH CITY
/*
$c = "SELECT id FROM city ORDER BY title ASC";
$d = mysqli_query($dbc, $c);
while ($city = mysqli_fetch_array($d, MYSQLI_ASSOC)) {
	
	$city_id=$city['id'];

	$q = "SELECT *, a.id AS article_id, a.url AS url, a.image_url AS image_url FROM article AS a JOIN source AS s ON a.source_id=s.id WHERE DATE(a.date_published)=CURDATE() AND s.city_id='$city_id' ORDER BY a.score DESC LIMIT 100";
	$r = mysqli_query($dbc, $q);
	$rank = 0;

	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

		$article_id = $row['article_id'];
		$article_image = $row['image_url'];
		$article_url = $row['url'];
		
		if (empty($article_image)) {
			// Get image from article webpage with embedly

			$embedly_url = urlencode($article_url);
			$api_key = '4449e1af1e9649b2996245496aeb35ac';
			$request_url = 'http://api.embed.ly/1/oembed?key=' . $api_key . '&url=' . $embedly_url;
			$json = file_get_contents($request_url);
			$result = json_decode($json);

			$image_url = $result->thumbnail_url;
			$image_width = $result->thumbnail_width;
			$image_height = $result->thumbnail_height;
			echo $image_url . ' - ' . $image_width . ' x ' . $image_width;
			
			// Update the article's rank and movement in the database
			$a = "UPDATE article SET image_url='$image_url', image_width='$image_width', image_height='$image_height' WHERE id='$article_id' LIMIT 1";
			$b = mysqli_query($dbc, $a) or trigger_error("Query: $a\n<br />mySQL error: " . mysqli_error($dbc));
		}

	}
}
*/
// ###############################
// End top 10 image logging
// ###############################
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// ###############################
// Rank and movement logging
// ###############################

// Assign rank based on score
$q = "SELECT id, rank FROM article ORDER BY score DESC";
$r = mysqli_query($dbc, $q);
$rank = 0;

while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$article_id = $row['id'];
	$rank++;
	
	echo $rank . ' - ' . $article_id . '<br>';
	
	if ($row['rank'] != 0) {
		$movement = $rank - $row['rank'];
	}
	
	// Update the article's rank and movement in the database
	$a = "UPDATE article SET rank='$rank' WHERE id='$article_id' LIMIT 1";
	$b = mysqli_query($dbc, $a);
}

// ###############################
// End rank and movement logging
// ###############################
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Calculate time it took for page load
$mtime = explode(' ', microtime());
$time = round($mtime[0] + $mtime[1] - $starttime, 3);

echo 'Count: ' . $i . ' Time: ' . $time;