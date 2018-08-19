<?php
/* @var $this CityController */
/* @var $model City */

$this->breadcrumbs=array(
	'Cities'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List City', 'url'=>array('index')),
	array('label'=>'Create City', 'url'=>array('create')),
	array('label'=>'View City', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage City', 'url'=>array('admin')),
);
?>

<div class="col-xs-12">

	<h1>Update City <?php echo $model->id; ?></h1>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>