<?php
/* @var $this CityController */
/* @var $dataProvider CActiveDataProvider */ ?>

<h1>Change Collection Preference</h1>

<h2>Your Collections</h2>
<?php foreach($collections as $collection):?>
	<div class="tplr-collection" style="margin-bottom: 20px;background: #fff; padding: 20px;">
		<div class="pull-right" style="margin-top:20px;">
			<a href="#" class="tplr-btn">Use This Collection</a>
		</div>
		
		<h3><?php echo $collection->title ?></h3>
		<p><?php echo $collection->description; ?></p>
		<p><strong>
		<?php
		$cities = City::model()->findAllByPk(explode(',', ($collection->cities)));
		foreach($cities as $city):?>
			<?php echo $city->title; ?> 
		<?php endforeach; ?>
		</strong></p>
		<ul>
		<?php
		$categories = Category::model()->findAllByPk(explode(',', ($collection->categories)));
		foreach($categories as $category):?>
			<li><?php echo $category->title; ?></li>
		<?php endforeach; ?>
		</ul>
	</div>
<?php endforeach; ?>
<a href="<?php echo $this->createUrl('collection/create'); ?>" class="tplr-btn"><i class="icon-plus"></i> Create Collection</a>

<h2>Popular Collections</h2>
<p>Coming soon!</p>