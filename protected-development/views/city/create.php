<?php
/* @var $this CityController */
/* @var $model City */

$this->breadcrumbs=array(
	'Cities'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List City', 'url'=>array('index')),
	array('label'=>'Manage City', 'url'=>array('admin')),
);
?>

<div class="col-xs-12">
	<h1>Create City</h1>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>