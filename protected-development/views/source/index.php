<?php
/* @var $this SourceController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle = 'Topular | List Source';

$this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'pills',
    'stacked'=>false,
    'items'=>array(
		array('label'=>'Create Source', 'url'=>array('create')),
		array('label'=>'Manage Source', 'url'=>array('admin')),
    ),
));
?>

<h1>Sources</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
