<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' | Login';
?>

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
<div class="col-md-6 col-xs-12">

	<h1>Log In</h1>

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
			
			<div class="hidden">
			<?php echo $form->checkBoxRow($model,'rememberMe'); ?>
			</div>
			
			<br>
			
			<div class="form-actions">
				<button class="btn btn-default btn-block" type="submit">Login</button>
			</div>

		<?php $this->endWidget(); ?>

	</div><!-- form -->

	<h3>Log in with facebook or twitter</h3>
	<p>Facebook and twitter log in is currently under development.  Check back soon!</p>
	<a href="<?php echo $this->createUrl('site/login', array('provider_name'=>'facebook')); ?>" class="btn btn-default btn-block disabled" role="button"><i class="icon-facebook"></i> Facebook</a>
	<a href="<?php echo $this->createUrl('site/login', array('provider_name'=>'twitter')); ?>" class="btn btn-default btn-block disabled" role="button"><i class="icon-twitter"></i> Twitter</a>
</div>

<div class="col-md-6 col-xs-12">
	<h1>Register</h1>
	
	<p>
		Register today to gain access to features such as:
		<ul>
			<li>Saving articles to your profile to read later</li>
			<li>Creating bundles to easily follow your favorite stories</li>
			<li>Submitting your favorite news sources to see how they rank</li>
		</ul>
		Registering is easy and free!
	</p>

	<a href="<?php echo $this->createUrl('user/register'); ?>" class="btn btn-default btn-block" role="button">Register</a>
</div>