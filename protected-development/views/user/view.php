<?php
/* @var $this UserController */
/* @var $model User */

$this->pageTitle = 'Topular | View Profile';
?>

<div class="col-md-6 col-xs-12">
	<h2>Personal Information</h2>
	<?php if ($model->image): ?>
	<div style="margin-right: 15px;">
	<img src="<?php echo Yii::app()->request->baseUrl . '/images/user/' . $model->image; ?>" class="profile-image img-thumbnail"></img>
	<p><small><a href="<?php echo $this->createUrl('user/edit'); ?>">change image</a></small></p>
	</div>
	<?php endif; ?>
	<p>Name: <strong><?php echo $model->first_name . ' ' . $model->last_name; ?></strong></p>
	<p>Email: <strong><?php echo $model->email; ?></strong></p>
	<p>Type: <strong><?php echo ucfirst($model->type); ?></strong></p>
</div>

<div class="col-md-6 col-xs-12">
	<h2>Your Preferences</h2>
	<p>Favorite City: <strong><?php echo $model->city->title; ?></strong> <small><a href="<?php echo $this->createUrl('city/index'); ?>">change</a></small></p>
	<p>Active Bundle: <strong><?php echo $model->bundle->title; ?></strong> <small><a href="<?php echo $this->createUrl('bundle/index'); ?>">change</a></small></p>
	<p>All Bundles:<br>
	<strong>
	<?php
	foreach ($model->bundles as $c) {
		echo $c->title . '<br>';
	}
	?>
	</strong>
	</p>
	<p>Article Timespan: <strong><?php echo ucfirst($model->timespan); ?></strong> <small><a href="#">change</a></small></p>
</div>

<div class="clearfix"></div>

<div class="col-xs-12">
	<h2>Recently Saved Articles</h2>
</div>

<?php
$articles = $model->articles(array('limit'=>3,'order'=>'`articles_articles`.`timestamp` DESC'));
//$articles = Article::model()->priority('score')->limit(5)->findAll();

echo $this->renderPartial('//article/articles', array('articles'=>$articles));
?>