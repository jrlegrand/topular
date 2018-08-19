<?php
/* @var $this UserController */
/* @var $model User */

$this->pageTitle = 'Topular | Register';
?>

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

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</div>

<div class="col-md-6 col-xs-12">

	<h1>Log In</h1>
	
	<p>Already have an account? Login here!</p>
	
	<a href="<?php echo $this->createUrl('site/login'); ?>" class="btn btn-default btn-block" role="button"><i class="icon-envelope"></i> Email</a>
	
	<br>
	<p>Facebook and twitter log in is currently under development.  Check back soon!</p>
	<a href="<?php echo $this->createUrl('site/login', array('provider_name'=>'facebook')); ?>" class="btn btn-default btn-block disabled" role="button"><i class="icon-facebook"></i> Facebook</a>
	<a href="<?php echo $this->createUrl('site/login', array('provider_name'=>'twitter')); ?>" class="btn btn-default btn-block disabled" role="button"><i class="icon-twitter"></i> Twitter</a>

</div>
