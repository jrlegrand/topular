<?php
mail('Joey <joey@indysphere.com>, Tyler <tyler@indysphere.com>', 'Cron Started', 'Starting cron job...');
// Start counting time for the page load
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];

// Make unlimited execution time
ini_set('max_execution_time', 0);

// Include SimplePie
include_once('../includes/simplepie.inc.php');

// Make the connection
$dbc = @mysqli_connect ('localhost', 'ab98812_joey', 'qubert12', 'ab98812_social') or die ('Could not connect to MySQL server');
//$dbc = @mysqli_connect ('localhost', 'root', 'password', 'social') or die ('Could not connect to MySQL server');

// Set the encoding
mysqli_set_charset($dbc, 'utf8');

// #################### INDYSPHERE FUNCTIONS ####################
function get_facebook($url) {
	$facebook_request_url = 'http://api.ak.facebook.com/restserver.php?v=1.0&method=links.getStats&urls=' . $url . '&format=json';
	$json = file_get_contents($facebook_request_url);
	$counts = json_decode($json);
	
	$data = array(
				'likes' => $counts[0]->like_count,
				'shares' => $counts[0]->share_count,
				'comments' => $counts[0]->comment_count
				);
				
	return $data;
}

function get_twitter($url) {
	$twitter_request_url = 'http://urls.api.twitter.com/1/urls/count.json?url=' . $url;
	$json = file_get_contents($twitter_request_url);
	$counts = json_decode($json);

	$retweets = $counts->count;
	return $retweets;
}

function get_reddit($url) {
	$reddit_request_url = 'http://buttons.reddit.com/button_info.json?url=' . $url;
	$json = file_get_contents($reddit_request_url);
	$counts = json_decode($json);
	
	$score = 0;
	if (count($counts->data->children) > 0)	$score = $counts->data->children[0]->data->score;
	
	return $score;
}

function get_linkedin($url) {
	$linkedin_request_url = 'http://www.linkedin.com/countserv/count/share?url=' . $url . '&format=json';
	$json = file_get_contents($linkedin_request_url);
	$counts = json_decode($json);
	
	$shares = $counts->count;
	return $shares;
}

function get_score($fb_likes, $fb_shares, $retweets, $reddit_score, $linkedin_shares, $google_plusones, $google_buzz) {
	$score = $fb_likes + $fb_shares + $retweets + $reddit_score + $linkedin_shares + $google_plusones + $google_buzz;
	
	return $score;
}

function get_first_image_url($html) {
	if (preg_match('/<img.+?src="(.+?)"/', $html, $matches)) {
		return $matches[1];
	} else {
		return '';
	}
}
// #################### INDYSPHERE FUNCTIONS ####################


// Create a new instance of the SimplePie object
$feed = new SimplePie();

$q = "SELECT feed_url FROM blogs ORDER BY blog_id ASC";
$r = mysqli_query($dbc, $q);

$blog_list = array();
// Make an array of all blog feed URLs
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$blog_list[] = $row['feed_url'];
}

// Set an array of feed URLs
$feed->set_feed_url($blog_list);
//$feed->set_feed_url('http://www.urbanophile.com/category/cities/indianapolis/feed/');

// Choose to not re-order the items by date. (optional)
$feed->enable_order_by_date(false);

// Initialize the whole SimplePie object.  Read the feed, process it, parse it, cache it, and
// all that other good stuff.  The feed's information will not be available to SimplePie before
// this is called.
$success = $feed->init();

// We'll make sure that the right content type and character encoding gets set automatically.
// This function will grab the proper character encoding, as well as set the content type to text/html.
$feed->handle_content_type();

$errors=0;
if ($feed->error())
{
	// If so, start a <div> element with a classname so we can style it.
	echo '<div class="sp_errors">' . "\r\n";

		// ... and display it.
		echo '<pre>' . print_r($feed->error()) . "</pre>\r\n";
		$errors = count($feed->error());

	// Close the <div> element we opened.
	echo '</div>' . "\r\n";
}

$updated=$new=$logged=0;
if ($success) {

	foreach($feed->get_items() as $item) {
		
		$article_link = $item->get_permalink();
		$article_title = mysqli_real_escape_string($dbc, $item->get_title());
		$article_content = $item->get_content();
		$article_date = $item->get_date('Y-m-d H:i:s');

		$url = $article_link;
		$json = file_get_contents("http://api.sharedcount.com/?url=" . $url);
		$counts = json_decode($json, true);
		
		$fb_likes = $counts['Facebook']['like_count'];
		$fb_shares = $counts['Facebook']['share_count'];
		$retweets = $counts['Twitter'];
		$linkedin_shares = $counts['LinkedIn'];
		$reddit_shares = $counts['Reddit'];
		$pinterest_pins = $counts['Pinterest'];
		$google_plusones = $counts['GooglePlusOne'];
		$google_buzz = $counts['Buzz'];
		
		echo 'f: ' . $counts['Facebook']['like_count'] . '+' . $counts['Facebook']['share_count'] . ' t:' . $counts['Twitter'] . ' l:' . $counts['LinkedIn'] . ' r:' . $counts['Reddit'] . ' p:' . $counts['Pinterest'] . ' g:' . $counts['GooglePlusOne'] . '+' . $counts['Buzz'] . '<br>';

		//$facebook = array(
		//				'likes'=>0,
		//				'shares'=>0
		//				);
		//$facebook = get_facebook($article_link);
		
		//$fb_likes = $facebook['likes'];
		//$fb_shares = $facebook['shares'];

		//$retweets = 0;		
		//$retweets = get_twitter($article_link);
		
		//$reddit_score = 0;
		//$reddit_score = get_reddit($article_link);
		
		//$linkedin_shares = 0;
		//$linkedin_shares = get_linkedin($article_link);
		
		// Check to see if article already exists by matching URL
		$q = "SELECT * FROM articles WHERE url='$article_link'";
		$r = mysqli_query($dbc, $q);
		
		// If article already exists, update all social stats and age
		// Update data table if age is one day older than age of last post in data table
		if (mysqli_num_rows($r) === 1) {
			
			$article = mysqli_fetch_assoc($r);

			// Set age as the difference in days between now and the initial time stamp
			$age = floor( abs(time() - strtotime($article['timestamp'])) / (60*60*24) );

			// If current age is one day older than database age then make new entry in data table
			if ($age > $article['age']) {
				$q = "INSERT INTO data (article_id, fb_likes, fb_shares, retweets, reddit_score, linkedin_shares, score, age, timestamp) VALUES ('{$article['article_id']}', '{$article['fb_likes']}', '{$article['fb_shares']}', '{$article['retweets']}', '{$article['reddit_score']}', '{$article['linkedin_shares']}', '{$article['score']}', '$age', NOW())";
				$r = mysqli_query($dbc, $q);
				$logged++;
			}			
			
			// Update image
			$image_url = get_first_image_url($article_content);
			
			// Update the article's social stats and age in the database
			$q = "UPDATE articles SET image_url='$image_url', age='$age', fb_likes='$fb_likes', fb_shares='$fb_shares', retweets='$retweets', reddit_score='$reddit_score', linkedin_shares='$linkedin_shares', google_plusones='$google_plusones', google_buzz='$google_buzz' WHERE url='$article_link' LIMIT 1";
			$r = mysqli_query($dbc, $q);
			
			$updated++;

		// If no article exists in database, insert a new article into the database
		} else {
			// Get first image in post content
			$image_url = get_first_image_url($article_content);
			
			// Get the feed url from the post and attach a blog id to it
			$blog_feed = $item->get_feed()->subscribe_url();
			
			$q = "SELECT blog_id FROM blogs WHERE feed_url='$blog_feed' LIMIT 1";
			$r = mysqli_query($dbc, $q);
			
			$row = mysqli_fetch_assoc($r);
			$blog_id = $row['blog_id'];
			
			// Create a new article entry in the database
			$q = "INSERT INTO articles (name, url, pub_date, blog_id, image_url, fb_likes, fb_shares, retweets, reddit_score, linkedin_shares, google_plusones, google_buzz, score, timestamp) VALUES ('$article_title', '$article_link', '$article_date', '$blog_id', '$image_url', '$fb_likes', '$fb_shares', '$retweets', '$reddit_score', '$linkedin_shares', '$google_plusones', '$google_buzz', '$score', NOW())";
			$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />mySQL error: " . mysqli_error($dbc));
			
			$new++;
		}
	
	}
	
// Calculate time it took for page load
$mtime = explode(' ', microtime());
$time = round($mtime[0] + $mtime[1] - $starttime, 3);

// Output results
$results = 'New: ' . $new . ' Updated: ' . $updated . ' Logged: ' . $logged . ' Errors: ' . $errors . ' Time: ' . $time . 's';
echo $results;
}

// Regardless of being a new or old article, calculate the score, trend, and rank
$q = "SELECT * FROM articles";
$r = mysqli_query($dbc, $q);

while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$score = get_score($row['fb_likes'], $row['fb_shares'], $row['retweets'], $row['reddit_score'], $row['linkedin_shares'], $row['google_plusones'], $row['google_buzz']);
	
	// Calculate trend between current score and score one hour ago
	$trend = $score - $row['score'];	
	
	// Update the article's score and trend in the database
	$a = "UPDATE articles SET score='$score', trend='$trend' WHERE article_id='{$row['article_id']}' LIMIT 1";
	$b = mysqli_query($dbc, $a);
}

// Assign rank based on score
$q = "SELECT article_id, rank FROM articles ORDER BY score DESC";
$r = mysqli_query($dbc, $q);
$rank = 0;

while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$rank++;
	
	if ($row['rank'] != 0) {
		$movement = $rank - $row['rank'];
	}
	
	// Update the article's rank and movement in the database
	$a = "UPDATE articles SET rank='$rank', movement='$movement' WHERE article_id='{$row['article_id']}' LIMIT 1";
	$b = mysqli_query($dbc, $a);
}

$to = 'Joey <joey@indysphere.com>, Tyler <tyler@indysphere.com>';
$subject = 'Cron Job Report';
$message = $results;
mail($to, $subject, $message);