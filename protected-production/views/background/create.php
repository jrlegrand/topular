<?php
/* @var $this BackgroundController */
/* @var $model Background */

$this->breadcrumbs=array(
	'Backgrounds'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Background', 'url'=>array('index')),
	array('label'=>'Manage Background', 'url'=>array('admin')),
);
?>

<div class="col-xs-12">
	<h1>Create Background</h1>

	<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>