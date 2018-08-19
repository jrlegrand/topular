<?php
/* @var $this SourceController */
/* @var $model Source */
$this->pageTitle = 'Topular | Admin Source';

$this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'pills',
    'stacked'=>false,
    'items'=>array(
		array('label'=>'List Source', 'url'=>array('index')),
		array('label'=>'Submit Source', 'url'=>array('submit')),
    ),
));

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#source-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Sources</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'source-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'twitter_handle',
		'url',
		'feed_url',
		array(
			'name'=>'category_id',
			'value'=>'$data->category->title',
		),
		array(
			'name'=>'city_id',
			'value'=>'$data->city->title',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
