<?php
/* @var $this bundleController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Topular | Change Bundle Preference';
Yii::app()->params['current_title'] = 'TEST';
?>

<div class="col-xs-12">
	<h1>Bundles</h1>
	<p class="lead">What is a bundle?</p>
	<p>A bundle is a group of your favorite cities and categories that you can bundle together as your own personal news source.
	For instance, if you want to keep tabs on what's new with Chicago's art and culture, you would bundle together the city of Chicago with the categories of Arts and Culture, Music, Film, etc.
	You can have as many bundles as you want and you can make them as basic or as complex as you desire.</p>
	<p><strong>Get started today!</strong></p>
	<br>
	<a href="<?php echo $this->createUrl('bundle/create'); ?>" class="btn btn-default btn-lg btn-block" role="button">Create New Bundle</a>
	<br>

	<h2>Your Bundles</h2>
	<?php if (count($bundles) == 0): ?>
		<p>You have not created any bundles.  Use the <strong>Create New Bundle</strong> button above to get started!</p>
	<?php endif; ?>
</div>

<?php foreach($bundles as $bundle):?>
<div class="row">
	<div class="col-md-9 col-xs-12 tplr-bundle">
		<span class="tplr-title"><?php echo $bundle->title; ?></span>
		<p><?php echo $bundle->description; ?></p>
		<?php if (isset($bundle->keywords) && !empty($bundle->keywords)): ?>
			<p><u>Keywords:</u> <?php echo $bundle->keywords; ?></p>
		<?php endif; ?>
		<p><strong>
		<?php
		$cities = City::model()->findAllByPk(explode(',', ($bundle->cities)));
		$i = 1;
		foreach($cities as $city):?>
			<?php echo $city->title . ($i > 0 && $i < count($cities) ? ' + ' : ''); $i++; ?> 
		<?php endforeach; ?>
		</strong></p>
		<ul>
		<?php
		$categories = Category::model()->findAllByPk(explode(',', ($bundle->categories)));
		foreach($categories as $category):?>
			<li><?php echo $category->title; ?></li>
		<?php endforeach; ?>
		</ul>
	</div>
	
	<div class="col-md-3 col-xs-12">
		<a href="<?php echo $this->createUrl('bundle/set', array('id'=>$bundle->id)); ?>" class="btn btn-default btn-block" role="button">Use This Bundle</a>
		<a href="<?php echo $this->createUrl('bundle/update', array('id'=>$bundle->id)); ?>" class="btn btn-default btn-block" role="button">Edit This Bundle</a>
		<a href="<?php echo $this->createUrl('bundle/delete', array('id'=>$bundle->id)); ?>" class="btn btn-default btn-block" role="button">Delete This Bundle</a>
	</div>
</div>
<?php endforeach; ?>

<div class="col-xs-12">
	<?php $this->widget('CLinkPager', array(
		'pages' => $pages,
	)) ?>
</div>
	
<div class="col-xs-12">
	<h2>Popular Bundles</h2>
	<p>Coming soon!</p>
</div>
