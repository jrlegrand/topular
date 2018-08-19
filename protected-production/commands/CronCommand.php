<?php

class CronCommand extends CConsoleCommand
{
	public function actionFacebook()
	{
		$article = Article::model()->week()->findAll();
		
		foreach ($article as $a)
		{
			// Get API JSON data
			$request = 'http://api.ak.facebook.com/restserver.php?v=1.0&method=links.getStats&urls=' . $a->url . '&format=json';
			$json = file_get_contents($request);
			$result = json_decode($json);
			
			// Assign data to variables
			$a->fb_likes = $result[0]->like_count;
			$a->fb_shares = $result[0]->share_count;
			$a->save();
		}

		$this->render('index');
	}
}