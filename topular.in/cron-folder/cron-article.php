<?php
include('cron-header.php');

// Include SimplePie
include_once('autoloader.php');
include_once('idn/idna_convert.class.php');

// Select all sources that aren't user submitted
$q = "SELECT id, feed_url FROM source WHERE user_submitted=0 ORDER BY id DESC";
$r = mysqli_query($dbc, $q);

$feed_list = array();
	
// Query database for all sources and return source ID and URL
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$feed_list[$row['id']] = $row['feed_url'];
}

$q = "SELECT id, url FROM article ORDER BY id DESC";
$r = mysqli_query($dbc, $q);

$article_list = array();

// Make an array of all article URLs and use article ID's as keys
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$article_list[$row['id']] = $row['url'];
}

// ################## Close DB connection ######################
//mysqli_close($dbc);
// ############################################################

$i=$errors=0;

foreach ($feed_list as $id => $url)
{

	// Create a new instance of the SimplePie object
	$feed = new SimplePie();

	// Set an array of feed URLs
	$feed->set_feed_url($url);

	// Set location of cache
	$feed->set_cache_location('/home/topular/topular.in/cron-folder/cache');

	// Set timeout in seconds
	$feed->set_timeout(15);

	// Choose to not re-order the items by date (optional)
	$feed->enable_order_by_date(false);

	// Initialize the whole SimplePie object
	// Read the feed, process it, parse it, cache it, and all that other good stuff
	// The feed's information will not be available to SimplePie before this is called
	$success = $feed->init();

	// We'll make sure that the right content type and character encoding gets set automatically
	// This function will grab the proper character encoding, as well as set the content type to text/html
	$feed->handle_content_type();

	// Show any errors and count the total number of errors
	if ($feed->error())
	{

		echo '<pre>' . print_r($feed->error()) . '</pre>';
		$errors += count($feed->error());

	}

	// ################## RE-open DB connection ######################
	//include('cron-header.php');
	// ##############################################################

	if ($success) {

		foreach($feed->get_items() as $item) {
			
			$article_url = $item->get_permalink();
			$article_title = mysqli_real_escape_string($dbc, $item->get_title());
			$article_date = $item->get_date('Y-m-d H:i:s');
			$article_summary = mysqli_real_escape_string($dbc, $item->get_description());
			$article_content = mysqli_real_escape_string($dbc, $item->get_content());
			$article_word_count = str_word_count($item->get_content());

			// Check to see if article already exists by matching URL
			// If article doesn't exist, add article to database
			if (!in_array($article_url, $article_list))
			{
				// Get the feed url from the post and attach a blog id to it
				$source_feed = $url;
				$source_id = $id;
				
				echo $source_feed . ' (' . $source_id . ') - ' . $article_title . '<br>';
				$i++;

				try {
					// Create a new article entry in the database
					$q = "INSERT INTO article (source_id, title, summary, content, url, word_count, date_published) VALUES ('$source_id', '$article_title', '$article_summary', '$article_content', '$article_url', '$article_word_count', '$article_date')";
					$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />mySQL error: " . mysqli_error($dbc));
				} catch (Exception $e) {}			
			}

		}
	}

	$feed->__destruct(); // Do what PHP should be doing on it's own.
	unset($item); 
	unset($feed); 

}
	
// Calculate time it took for page load
$mtime = explode(' ', microtime());
$time = round($mtime[0] + $mtime[1] - $starttime, 3);

// Output results
echo 'New: ' . $i . ' Errors: ' . $errors . ' Time: ' . $time . 's' . ' Memory: ' . memory_get_usage() / 1000000 . 'MB';