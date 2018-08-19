<?php
/* @var $this SourceController */
/* @var $model Source */
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

	<?php echo $form->textFieldRow($model,'title'); ?>
	
	<?php echo $form->textFieldRow($model,'url'); ?>
	
	<?php echo $form->textFieldRow($model,'feed_url'); ?>

	<?php 
		$list = CHtml::listData(City::model()->findAll(array('order' => 'title')), 'id', 'title');
		echo $form->dropDownListRow($model,'city_id',$list); 
	?>
	
	<?php 
		$list = CHtml::listData(Category::model()->findAll(array('order' => 'title')), 'id', 'title');
		echo $form->dropDownListRow($model,'category_id',$list); 
	?>

	<?php echo $form->textFieldRow($model,'twitter_handle'); ?>

	<?php echo $form->textFieldRow($model,'facebook_handle'); ?>
	
	<br>
	<div class="form-actions">
		<button class="btn btn-default" type="submit"><?php echo ($model->isNewRecord ? 'Create' : 'Save'); ?></button>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->