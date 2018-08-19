<?php
/* @var $this BundleController */
/* @var $model Bundle */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'bundle-form',
	'focus'=>array($model,'title'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-row">
	    <?php echo $form->labelEx($model,'title'); ?>
	    <?php echo $form->textField($model,'title'); ?>
	    <?php echo $form->error($model,'title'); ?>
	</div>
	
	<div class="form-row">
	    <?php echo $form->labelEx($model,'description'); ?>
	    <?php echo $form->textArea($model,'description'); ?>
	    <?php echo $form->error($model,'description'); ?>
	</div>
	
	<div class="form-row">
	    <?php echo $form->labelEx($model,'keywords'); ?>
	    <?php echo $form->textField($model,'keywords'); ?>
	    <?php echo $form->error($model,'keywords'); ?>
		<small>Separate multiple keywords by commas.</small>
	</div>
	
	<div class="form-row">
		<?php echo $form->labelEx($model,'cities'); ?>
		<br>
		<?php echo $form->checkBoxList($model,'cities',CHtml::listData(City::model()->findAll(array('order'=>'title ASC')),'id','title')); ?>
		<?php echo $form->error($model,'cities'); ?>
	</div>
	
	<br>
	
	<div class="form-row">
		<?php echo $form->labelEx($model,'categories'); ?>
		<br>
		<?php echo $form->checkBoxList($model,'categories',CHtml::listData(Category::model()->findAll(array('order'=>'title ASC')),'id','title')); ?>
		<?php echo $form->error($model,'categories'); ?>
	</div>
	
	<br>
	
	<div class="form-actions">
		<button type="submit" class="btn btn-default btn-block email-share"><?php echo ($model->isNewRecord ? 'Create' : 'Save'); ?></button>
	</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->