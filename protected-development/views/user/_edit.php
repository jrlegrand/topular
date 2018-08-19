<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data'),
)); ?>
	
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->textFieldRow($model,'email',array('disabled'=>true)); ?>

	<?php echo $form->textFieldRow($model,'first_name'); ?>
	
	<?php echo $form->textFieldRow($model,'last_name'); ?>
	
	<?php if ($model->image): ?>
	<br>
	<img src="<?php echo Yii::app()->request->baseUrl . '/images/user/' . $model->image; ?>" class="profile-image img-polaroid"></img>
	<?php endif; ?>
	
    <?php echo $form->fileFieldRow($model, 'image'); ?>

    <?php echo $form->dropDownListRow($model, 'city_id', array(2=>'Chicago', 1=>'Indianapolis')); ?>

	<br>
	<div class="form-actions">
		<button class="btn btn-default" type="submit">Submit</button>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->