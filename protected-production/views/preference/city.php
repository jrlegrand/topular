<?php
/* @var $this CityController */
/* @var $dataProvider CActiveDataProvider */ ?>

<h1>Change City Preference</h1>

<p><a href="<?php echo $this->createUrl('article/index'); ?>">All Cities</a></p>
<?php foreach($cities as $city):?>
	<p><a href="<?php echo $this->createUrl('article/index', array('city'=>strtolower($city->title))); ?>"><?php echo $city->title ?></a></p>
<?php endforeach?>