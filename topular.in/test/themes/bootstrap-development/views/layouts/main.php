<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/chosen/chosen.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style-tplr.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/fontawesome/fontawesome.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/topular.css" />
	<link href='http://fonts.googleapis.com/css?family=Coda' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Noto+Sans' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700' rel='stylesheet' type='text/css'>
</head>

<body>

	<div id="pagewrap" class="wrap">
		<div class="menu" id="nav-menu">
			<?php
			$menu = Article::getMenuList();
			$this->renderPartial('//article/menu', array('menu'=>$menu));
			?>
		</div>

		<div id="articles">
			<div class="articles-inner">
				<?php echo $content; ?>
			</div>
		</div>
		
		<div id="profile">
			<div id="dd" class="wrapper-dropdown-5" tabindex="1">
						<ul class="dropdown">
							<li><a href="<?php echo $this->createUrl('user/view'); ?>" class="icon" title="View profile"><i class="icon-user"></i></option>
							<li><a href="<?php echo $this->createUrl('user/articles'); ?>" class="icon" title="Saved articles"><i class="icon-star"></i></option>
							<li><a href="<?php echo $this->createUrl('user/edit'); ?>" class="icon" title="Edit profile"><i class="icon-wrench"></i></option>
							<li><a href="<?php echo $this->createUrl('site/logout'); ?>" class="icon" title="Logout"><i class="icon-off"></i></option>
						</ul>
					</div>
		</div>
	</div>

<!-- Google analytics -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/google/google.analytics.js" type="text/javascript"></script>

</body>
</html>