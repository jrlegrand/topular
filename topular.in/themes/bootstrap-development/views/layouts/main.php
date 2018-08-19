<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- For Google -->
		<meta name="description" content="<?php echo (isset($this->meta_description) ? $this->meta_description : 'What are the best reads in your city? Topular shows you. We take all the stories from your city and rank them by social impact. The best content in your city is decided by you, as it should be.'); ?>">
		<!-- For Facebook -->
		<!--<meta property="og:title" content="<?php echo (isset($this->meta_title) ? $this->meta_title : ''); ?>" />-->
		<meta property="og:type" content="<?php echo (isset($this->meta_type) ? $this->meta_type : ''); ?>" />
		<meta property="og:image" content="<?php echo (isset($this->meta_image) ? $this->meta_image : ''); ?>" />
		<!--<meta property="og:url" content="<?php echo (isset($this->meta_url) ? $this->meta_url : ''); ?>" />-->
		<meta property="og:description" content="<?php echo (isset($this->meta_description) ? $this->meta_description : ''); ?>" />
		<!-- for Twitter -->          
		<meta name="twitter:card" content="summary" />
		<meta name="twitter:title" content="<?php echo (isset($this->meta_title) ? $this->meta_title : ''); ?>" />
		<meta name="twitter:description" content="<?php echo (isset($this->meta_description) ? $this->meta_description : ''); ?>" />
		<meta name="twitter:image" content="<?php echo (isset($this->meta_image) ? $this->meta_image : ''); ?>" />
		
		<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
		<link rel="icon" type="image/x-icon" href="<?php echo Yii::app()->baseUrl; ?>/favicon.ico">
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/fontawesome/fontawesome.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/topular.css" />
		<link href='http://fonts.googleapis.com/css?family=Coda' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Noto+Sans' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="../../assets/js/html5shiv.js"></script>
		  <script src="../../assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<div class="visible-lg">
			<a href="https://github.com/BeTopular/topular.in"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/38ef81f8aca64bb9a64448d0d70f1308ef5341ab/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6461726b626c75655f3132313632312e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png"></a>		
		</div>
		
		<div class="row">
			<div class="col-xs-12" id="main">
				<div class="row">
					<?php
					$menu = Article::getMenuList();
					$this->renderPartial('//article/menu', array('menu'=>$menu));
					?>
				</div>
				
				<div class="row">
					<?php echo $content; ?>
				</div>
				
				<div class="row" id="footer">
					<div id="footer-inner">
						Copyright 2014 Topular<br>
						<a href="<?php echo $this->createUrl('background/index'); ?>" style="color: #000;"><img src="http://mirrors.creativecommons.org/presskit/icons/cc.large.png" height="14" width="14" /> Background image rights</a>
					</div>
				</div>
			</div>
		</div>
		<!--</div>-->
		
		<div class="modal fade" id="modal-share">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>Share Article</h3>
			  </div>
			  <div class="modal-body">
				Loading...
			  </div>
			  <div class="modal-footer">
				<button type="button" href="#" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		<div class="modal fade" id="modal-sign-up">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>Sign Up or Log In</h3>
			  </div>
			  <div class="modal-body">
				<p><strong>Please sign up or log in to save articles.</strong></p>
				<p>
					Sign up today to gain access to features such as:
					<ul>
						<li>Saving articles to your profile to read later</li>
						<li>Creating bundles to easily follow your favorite stories</li>
						<li>Submitting your favorite news sources to see how they rank</li>
					</ul>
					Signing up is easy and free!
				</p>
				</div>
			  <div class="modal-footer">
				<a type="button" href="<?php echo $this->createUrl('user/register'); ?>" class="btn btn-primary">Sign up</a>
				<a type="button" href="<?php echo $this->createUrl('site/login'); ?>" class="btn btn-primary">Log in</a>
				<button type="button" href="#" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<!-- Google analytics -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/google/google.analytics.js" type="text/javascript"></script>
		<!-- Other javascript -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap/bootstrap.min.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/backstretch/backstretch.min.js"></script>
		
		<script>
		$('#menu').affix({
			offset: { top: 0, bottom: 0	}		
		});
		
		$('#search-button').click(function(){
			if($('#search-menu').is(':visible')) {
				$('#search-menu').slideUp();
			} else {				
				$('#site-menu').hide();
				$('#search-menu').slideDown();
			}
		});
		
		$('#menu-button').click(function(){
			if($('#site-menu').is(':visible')) {
				$('#site-menu').slideUp();
			} else {				
				$('#search-menu').hide();
				$('#site-menu').slideDown();
			}
		});
		
		$('.icon-remove').click(function(){
			$('#site-menu').slideUp();
		});
		
		// Topular save buttons
		$('.tplr-save-btn').click(function() {
			var button = $(this);
			var save = '<?php echo Yii::app()->createUrl('article/save'); ?>';
			var unsave = '<?php echo Yii::app()->createUrl('article/unsave'); ?>';
			var id = $(this).attr('data-id');
			
			if (button.hasClass('saved')) {
				var url = unsave;
			} else if (button.hasClass('unsaved')) {
				var url = save;
			}
			
			var request = $.ajax({
				url: url,
				data: {id: id},
				type: 'get',
				dataType: 'text',
			}).done(function(result) {
				if (result == 'SAVED') {
					button.html('<div class="score-big-text"><i class="icon-trash"></i></div><div class="score-small-text">Unsave</div>');
					button.removeClass('unsaved');
					button.addClass('saved');
				} else if (result == 'UNSAVED') {
					button.html('<div class="score-big-text"><i class="icon-star"></i></div><div class="score-small-text">Save</div>');
					button.removeClass('saved');
					button.addClass('unsaved');
				} else if (result == 'LOGGED_OUT') {
					$('#modal-sign-up').modal('show');
				}
			});
		});

		// Hack to make modals refresh
		$("a[data-target=#modal-share]").click(function(e) {
			e.preventDefault();
			var target = $(this).attr("href");

			// Load the url and show modal on success
			$("#modal-share .modal-body").load(target, function() { 
				 $("#modal-share").modal("show"); 
			});
		});
		
		// Background image functionality
		$.backstretch(<?php echo Background::model()->getUrl(); ?>);

		/*
		// Code for detecting up vs down scroll for menu resizing
		var lastScrollTop = 0;
		$(window).scroll(function(event){
			var st = $(this).scrollTop();
			if (st > lastScrollTop){
				// Downscroll code
				//alert ('DOWN scroll');
			} else {
				// Upscroll code
				//alert ('UP scroll');
			}
			lastScrollTop = st;
		});
		*/
		
		</script>
	</body>
</html>