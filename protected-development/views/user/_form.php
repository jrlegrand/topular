<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'login-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->textFieldRow($model,'email'); ?>

	<?php echo $form->passwordFieldRow($model,'pass'); ?>

	<?php echo $form->passwordFieldRow($model,'passCompare'); ?>

	<br>
	
	<div class="form-actions">
		<button class="btn btn-default btn-block" type="submit"><?php echo ($model->isNewRecord ? 'Register' : 'Save'); ?></button>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->