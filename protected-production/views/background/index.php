<?php
/* @var $this BackgroundController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Backgrounds',
);

$this->menu=array(
	array('label'=>'Create Background', 'url'=>array('create')),
);
?>

<div class="col-xs-12">
<h1>Backgrounds</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</div>