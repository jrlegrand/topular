<?php
/* @var $this CollectionController */
/* @var $model Collection */

$this->pageTitle = 'Topular | Update Bundle';
?>

<div class="col-xs-12">
	<h1>Update Bundle <?php echo $model->title; ?></h1>

	<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>