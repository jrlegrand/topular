<?php
/* @var $this SourceController */
/* @var $model Source */
$this->pageTitle = 'Topular | Update Source';

$this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'pills',
    'stacked'=>false,
    'items'=>array(
		array('label'=>'List Source', 'url'=>array('index')),
		array('label'=>'Create Source', 'url'=>array('create')),
		array('label'=>'View Source', 'url'=>array('view', 'id'=>$model->id)),
		array('label'=>'Manage Source', 'url'=>array('admin')),
    ),
));
?>

<h1>Update Source <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>