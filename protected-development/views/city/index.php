<?php
/* @var $this CityController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Topular | Change City Preference';
?>

<div class="col-xs-12">
	<h1>Change City Preference</h1>

	<a class="btn btn-default btn-lg btn-block" href="<?php echo $this->createUrl('city/set', array('id'=>0)); ?>">All Cities</a>
	<?php foreach($cities as $city):?>
		<a class="btn btn-default btn-lg btn-block" href="<?php echo $this->createUrl('city/set', array('id'=>$city->id)); ?>"><?php echo $city->title ?></a>
	<?php endforeach?>
</div>