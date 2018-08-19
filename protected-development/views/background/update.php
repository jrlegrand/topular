<?php
/* @var $this BackgroundController */
/* @var $model Background */

$this->breadcrumbs=array(
	'Backgrounds'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Background', 'url'=>array('index')),
	array('label'=>'Create Background', 'url'=>array('create')),
	array('label'=>'View Background', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Background', 'url'=>array('admin')),
);
?>

<div class="col-xs-12">
<h1>Update Background <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>