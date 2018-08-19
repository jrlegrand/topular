<?php
include('cron-header.php');

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// ###############################
// Top 10 image logging
// ###############################

// Get top 100 articles for the day FOR EACH CITY
$c = "SELECT id FROM city ORDER BY title ASC";
$d = mysqli_query($dbc, $c);
while ($city = mysqli_fetch_array($d, MYSQLI_ASSOC)) {
	
	$city_id=$city['id'];

	$q = "SELECT *, a.id AS article_id, a.url AS url, a.image_url AS image_url FROM article AS a JOIN source AS s ON a.source_id=s.id WHERE DATE(a.date_published)=CURDATE() AND s.city_id='$city_id' ORDER BY a.score DESC LIMIT 100";
	$r = mysqli_query($dbc, $q);
	$rank = 0;

	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

		if (!$row['hide_image'])
		{
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
}

// ###############################
// End top 10 image logging
// ###############################
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
