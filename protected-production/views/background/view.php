<?php
/* @var $this BackgroundController */
/* @var $model Background */

$this->breadcrumbs=array(
	'Backgrounds'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Background', 'url'=>array('index')),
	array('label'=>'Create Background', 'url'=>array('create')),
	array('label'=>'Update Background', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Background', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Background', 'url'=>array('admin')),
);
?>

<div class="col-xs-12">
<h1>View Background #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'url',
		'source_url',
		'author',
		'city_id',
		'category_id',
		'timestamp',
	),
)); ?>
</div>