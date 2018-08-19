<?php
/* @var $this UserController */
/* @var $model User */

$this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'pills',
    'stacked'=>false,
    'items'=>array(
		array('label'=>'List User', 'url'=>array('index')),
		array('label'=>'Create User', 'url'=>array('create')),
    ),
));

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="col-xs-12">
	<h1>Manage Users</h1>

	<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
	</p>

	<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>


	<?php $this->widget('bootstrap.widgets.TbGridView', array(
		'id'=>'user-grid',
		'type'=>'striped bordered condensed',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'columns'=>array(
			'id',
			'email',
			'type',
			array(
				'name'=>'city_id',
				'value'=>$model->city->title,
			),
			array(
				'class'=>'CButtonColumn',
			),
		),
	)); ?>

</div>