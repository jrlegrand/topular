<?php
/* @var $this UserController */
/* @var $model User */

$this->pageTitle = 'Topular | Edit Profile';
?>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>false, // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true), // success, info, warning, error or danger
        ),
    )); ?>

<div class="col-xs-12">
	<h1>Edit Profile</h1>
</div>
<div class="col-md-6 col-xs-12">
	<?php echo $this->renderPartial('_edit', array('model'=>$model)); ?>
</div>