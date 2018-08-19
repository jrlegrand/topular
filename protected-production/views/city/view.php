<?php
/* @var $this CityController */
/* @var $model City */

$this->breadcrumbs=array(
	$model->title,
);

$this->widget('bootstrap.widgets.TbMenu', array(
	'type'=>'pills',
	'items'=>array(
		array('label'=>'List City', 'url'=>array('index')),
		array('label'=>'Create City', 'url'=>array('create')),
		array('label'=>'Update City', 'url'=>array('update', 'id'=>$model->id)),
		array('label'=>'Delete City', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
		array('label'=>'Manage City', 'url'=>array('admin')),
	),
)); ?>