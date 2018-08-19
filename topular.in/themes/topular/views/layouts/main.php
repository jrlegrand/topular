<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php //Yii::app()->bootstrap->register(); ?>

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/fontawesome.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.pageslide.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/topular.css" />
	<link href='http://fonts.googleapis.com/css?family=Noto+Sans' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Noto+Serif:400,700' rel='stylesheet' type='text/css'>
</head>

<body>

<!-- Top navigation bar -->
<div id="topular-nav">
	<div style="float:left;margin-left:15px;">
		<!--<a href="<?php //echo $this->createUrl('article/menu'); ?>" id="article-menu" style="color:#ffffff;text-decoration:none;">-->
		<a href="#article-menu" id="article-nav" style="color:#ffffff;text-decoration:none;">
			<i class="icon-align-justify"></i>
		</a>
	</div>

	<div style="float:right;margin-right:15px;">
		<a href="#profile-menu" id="user-nav" style="color:#ffffff;text-decoration:none;">
			<i class="icon-user"></i>
		</a>
	</div>

	<div>
		<a class="brand" href="#article-menu" style="color:#ffffff;text-decoration:none;">
			<?php echo CHtml::encode($this->pageTitle); ?>
		</a>
	</div>
</div>

<!-- Main page content -->
<div class="container" id="page">
	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> Topular<br/>
		All Rights Reserved.<br/>
		<a href="javascript: void(0)" id="go-top"><i class="icon-arrow-up"></i> Top</a>
	</div>
</div>

<div id="article-menu" style="display:none;">
	<?php
	$menu = Article::getMenuList();
	$this->renderPartial('//article/menu', array('menu'=>$menu));
	?>
</div>

<div id="profile-menu" style="display:none;">
	<?php
	$user = User::model()->findByPk(Yii::app()->user->getId());
	$this->renderPartial('//user/menu', array('user'=>$user));
	?>
</div>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.pageslide.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.masonry.min.js"></script>
<script>
	$('#article-nav, #subnav-title').pageslide({
		direction: 'right',
	});
	
	$('#user-nav').pageslide({
		direction: 'left'
	});
	
	$('a.reveal-menu').toggle(
		function() {
			$(this).siblings('div.hidden-menu').show('fast');
	},
		function() {
			$(this).siblings('div.hidden-menu').hide('fast');
	});
	
	$('a.expand-category').toggle(
		function() {
			$(this).html('<i class="icon-angle-down"></i>');
			$(this).siblings('div.source-menu').show('fast');
	},
		function() {
			$(this).html('<i class="icon-angle-right"></i>');
			$(this).siblings('div.source-menu').hide('fast');
	});

	// Show or hide the sticky footer button
	$(window).scroll(function() {
		if ($(this).scrollTop() > 200) {
			$('#go-top').fadeIn(200);
		} else {
			$('#go-top').fadeOut(200);
		}
	});
	
	// Animate the scroll to top
	$('#go-top').click(function(event) {
		event.preventDefault();
		
		$('html, body').animate({scrollTop: 0}, 300);
	})

	// Masonry
	var $container = $('#articles');
	$container.imagesLoaded(function(){
	  $container.masonry({
		// options
		itemSelector : '.article',
		columnWidth : 380
	  });
	});
	
	// Topular save buttons
	$('.topular-save-link').click(function() {
		var button = $(this);
		var save = '<?php echo Yii::app()->createUrl('article/save'); ?>';
		var unsave = '<?php echo Yii::app()->createUrl('article/unsave'); ?>';
		var url;
		if (button.hasClass('saved')) {
			url = unsave;
		} else if (button.hasClass('unsaved')) {
			url = save;
		}
		var id = $(this).attr('rel');
		var request = $.ajax({
			url: url,
			data: {id: id},
			type: 'get',
			dataType: 'text',
		}).done(function(result) {
			if (result == 'SAVED') {
				button.html('<i class="icon-trash"></i>');
				button.removeClass('unsaved');
				button.addClass('saved');
			} else if (result == 'UNSAVED') {
				button.html('<i class="icon-star"></i>');
				button.removeClass('saved');
				button.addClass('unsaved');
			}	
		});
	})
</script>

</body>

</html>