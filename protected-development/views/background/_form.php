<?php
/* @var $this BackgroundController */
/* @var $model Background */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'background-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>2083)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source_url'); ?>
		<?php echo $form->textField($model,'source_url',array('size'=>60,'maxlength'=>2083)); ?>
		<?php echo $form->error($model,'source_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'author'); ?>
		<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'author'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city_id'); ?>
		<?php echo $form->textField($model,'city_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'city_id'); ?>
	</div>

	<br>
	<div class="form-actions">
		<button class="btn btn-default" type="submit"><?php echo ($model->isNewRecord ? 'Create' : 'Save'); ?></button>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->