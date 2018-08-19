<?php
include('cron-header.php');

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// ###############################
// Top 10 article logging
// ###############################

// Get top 10 articles for the week FOR EACH CITY

$message = '';

$c = "SELECT id, title FROM city ORDER BY title ASC";
$d = mysqli_query($dbc, $c);
while ($city = mysqli_fetch_array($d, MYSQLI_ASSOC)) {
	
	$city_id=$city['id'];
	$city_title=$city['title'];
	
	$message .= '<strong>City: ' . $city_title . '</strong><br>';
	$q = "SELECT * FROM article AS a JOIN source AS s ON a.source_id=s.id WHERE DATE(a.date_published) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE() AND s.city_id='$city_id'";
	$r = mysqli_query($dbc, $q);
	$count = mysqli_num_rows($r);
	$message .= 'New articles this week: ' . $count . '<br><br>';

	$q = "SELECT *, a.id AS article_id, a.url AS url, s.title AS source_title, a.title AS article_title, a.image_url AS image_url FROM article AS a JOIN source AS s ON a.source_id=s.id WHERE DATE(a.date_published) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE() AND s.city_id='$city_id' ORDER BY a.score DESC LIMIT 10";
	$r = mysqli_query($dbc, $q);
	$i = 0;

	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		
		$i++;
		$article_id = $row['article_id'];
		$article_image = $row['image_url'];
		$source_title = $row['source_title'];
		$article_url = $row['url'];
		$bitly_url = $row['bitly_url'];
		$article_title = stripslashes($row['article_title']);
	
		$message .= '#' . $i . ' Article: ' . $article_title . ' - <a href="' . $bitly_url . '">' . $bitly_url . '</a> by ' . $source_title . ' [' . $article_image . ']<br>';

	}
	
	$message .= '<br>';

	$e = "SELECT * FROM category";
	$f = mysqli_query($dbc, $e);

	while ($category = mysqli_fetch_array($f, MYSQLI_ASSOC)) {
		
		$category_id=$category['id'];
		$category_title=$category['title'];
		
		
		
		$q = "SELECT *, a.score AS article_score FROM article AS a JOIN source AS s ON a.source_id=s.id WHERE DATE(a.date_published) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE() AND s.category_id='$category_id' AND s.city_id='$city_id'";
		$r = mysqli_query($dbc, $q);
		$num_rows = mysqli_num_rows($r);
		
		$q = "SELECT *, SUM(a.score) AS article_score FROM article AS a JOIN source AS s ON a.source_id=s.id WHERE DATE(a.date_published) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE() AND s.category_id='$category_id' AND s.city_id='$city_id'";
		$r = mysqli_query($dbc, $q);
		
		$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		
		$article_score = $row['article_score']; 
		
		if ($num_rows > 0)
			$message .= 'Average ' . $category_title . ' score: ' . round($article_score / $num_rows) . ' (n = ' . $num_rows . ')<br>';
	}
	
	$message .= '<br>';
}

// ###############################
// End top 10 article logging
// ###############################
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

echo $message;

$date = date('n/j/Y');

$to = 'yourfriends@topular.in';
$subject = 'Topular Weekly Report ' . $date;
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'To: Topular Team <yourfriends@topular.in>' . "\r\n";
$headers .= 'From: Topular <noreply@topular.in>' . "\r\n";

mail ($to, $subject, $message, $headers);

// Calculate time it took for page load
//$mtime = explode(' ', microtime());
//$time = round($mtime[0] + $mtime[1] - $starttime, 3);

//echo 'Count: ' . $i . ' Time: ' . $time;