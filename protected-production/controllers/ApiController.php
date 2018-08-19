<?php

class ApiController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform all actions
				'actions'=>array('index'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$criteria = new CDbCriteria();
		$criteria->condition = "`t`.`source_id`='" . $_GET['source'] . "'";
		$criteria->order = "`t`.`score` DESC";
		$criteria->limit = 10;
		$articles = Article::model()->week()->findAll($criteria);
		foreach ($articles as $a)
		{	
			echo '<pre>';
			echo json_encode(array(
				'title'=>$a->title,
				'url'=>$a->url,
				'bitly_url'=>$a->bitly_url,
				'score'=>$a->score,
				'fb_likes'=>$a->fb_likes,
				'fb_shares'=>$a->fb_shares,
				'retweets'=>$a->retweets,
				'linkedin_shares'=>$a->linkedin_shares,
				'image_url'=>$a->image_url,
				'date_published'=>$a->date_published,
			));
			echo '</pre>';
		}
	}
	
}