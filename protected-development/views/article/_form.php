<?php
/* @var $this ArticleController */
/* @var $model Article */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'article-form',
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
		<?php echo $form->labelEx($model,'bitly_url'); ?>
		<?php echo $form->textField($model,'bitly_url',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'bitly_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'image_url'); ?>
		<?php echo $form->textField($model,'image_url',array('size'=>60,'maxlength'=>2083)); ?>
		<?php echo $form->error($model,'image_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_published'); ?>
		<?php echo $form->textField($model,'date_published'); ?>
		<?php echo $form->error($model,'date_published'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source_id'); ?>
		<?php echo $form->textField($model,'source_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'source_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fb_likes'); ?>
		<?php echo $form->textField($model,'fb_likes',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'fb_likes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fb_shares'); ?>
		<?php echo $form->textField($model,'fb_shares',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'fb_shares'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'retweets'); ?>
		<?php echo $form->textField($model,'retweets',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'retweets'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'linkedin_shares'); ?>
		<?php echo $form->textField($model,'linkedin_shares',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'linkedin_shares'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'score'); ?>
		<?php echo $form->textField($model,'score',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'score'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rank'); ?>
		<?php echo $form->textField($model,'rank',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'rank'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'movement_day'); ?>
		<?php echo $form->textField($model,'movement_day'); ?>
		<?php echo $form->error($model,'movement_day'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'movement_week'); ?>
		<?php echo $form->textField($model,'movement_week'); ?>
		<?php echo $form->error($model,'movement_week'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'movement_month'); ?>
		<?php echo $form->textField($model,'movement_month'); ?>
		<?php echo $form->error($model,'movement_month'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'trend'); ?>
		<?php echo $form->textField($model,'trend'); ?>
		<?php echo $form->error($model,'trend'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'age'); ?>
		<?php echo $form->textField($model,'age'); ?>
		<?php echo $form->error($model,'age'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hidden'); ?>
		<?php echo $form->textField($model,'hidden'); ?>
		<?php echo $form->error($model,'hidden'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'timestamp'); ?>
		<?php echo $form->textField($model,'timestamp'); ?>
		<?php echo $form->error($model,'timestamp'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->