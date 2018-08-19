<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' | Login';
?>
<div class="row">
<div class="span12">

<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>false, // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true), // success, info, warning, error or danger
            'warning'=>array('block'=>true, 'fade'=>true), // success, info, warning, error or danger
        ),
    )); ?>
<div class="span6">

<h1>Login</h1>

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

	<?php 
	// BUG: if email associated with a provider error, this should still show the password field!
	if(empty($provider)) {
		// Don't display the password field if the provider is connected
		echo $form->passwordFieldRow($model,'password');
	}
	?>

	<?php echo $form->checkBoxRow($model,'rememberMe'); ?>

	<div class="form-actions">
		<button type="submit" class="tplr-btn">Login</button>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<h3>Login with facebook or twitter</h3>
<a href="<?php echo $this->createUrl('site/login', array('provider_name'=>'facebook')); ?>" class="tplr-btn"><i class="icon-facebook"></i> Facebook</a>
 <a href="<?php echo $this->createUrl('site/login', array('provider_name'=>'twitter')); ?>" class="tplr-btn"><i class="icon-twitter"></i> Twitter</a>
<br><br>
<br>
</div>

<div class="span5">
<h1 style="margin-bottom: 20px;">Register</h1>
<a href="<?php echo $this->createUrl('user/register'); ?>" class="tplr-btn">Register</a>
</div>
</div>
</div>