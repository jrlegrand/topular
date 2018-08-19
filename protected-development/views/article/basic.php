<div id="articles">
	<?php foreach($articles as $article):?>

	<!--<article class="article<?php //echo (!empty($article->image_url) && $article->image_width <= 300 && $article->image_width >= 150 ? ' small' : ''); ?>" style="overflow: hidden;">-->
	<div class="article">

		<?php if (!empty($article->image_url) && $article->image_width >= 150): ?>
		<div class="article-image-container">
			<a href="<?php echo $article->getUrl(); ?>" target="_blank" class="iframe-modal" title="<?php echo $article->title; ?>">
				<img src="<?php echo $article->image_url; ?>" />
			</a>
		</div>
		<?php endif; ?>
		
		<div class="big-score pull-right" style="width: 100px;">
			<?php echo $article->score; ?>
		</div>
		
		<div class="article-content-wrapper">
		
			<div class="source-content">
				<!-- dot = &#183; -->
				<div class="source-title"><a href="<?php echo $article->source->url; ?>" title="<?php echo $article->source->title; ?>"><?php echo $article->source->title; ?></a></div>
				<div class="category-title"><?php echo $article->source->category->title; ?></div>
			</div>
			
			<div class="article-content">
				<a href="<?php echo $article->getUrl(); ?>" target="_blank" class="iframe-modal" title="<?php echo $article->title; ?>">
					<h2><?php echo stripslashes($article->title); ?></h2>
				</a>
			</div>
			
			<?php if (!Yii::app()->session['city']): ?>
			<div class="city-content">
				<span class="label">
					<?php echo ucfirst($article->source->city->title); ?>
				</span>
			</div>
			<?php endif; ?>
			
			<footer>
				<span class="date-published">
					<i class="icon-time"></i> 
					<?php echo $article->timeSince($article->date_published); ?> ago 
				</span>
				 / 
				<span class="article-shares-links">
					<a class="facebook-share" title="Share via Facebook" style="text-decoration:none;" onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo urlencode($article->title) . ' - ' . urlencode($article->source->title); ?>&amp;p[summary]=Discovered via Topular&amp;p[url]=<?php echo $article->getUrl(); ?>&amp;<?php echo (!empty($article->image_url) ? 'p[images][0]=' . $article->image_url : ''); ?>','sharer','toolbar=0,status=0,width=580,height=325');" href="javascript: void(0)">
						<i class="icon-facebook-sign"></i>
						<?php echo $article->fb_likes + $article->fb_shares; ?>
					</a>
					<a class="twitter-share" title="Share via Twitter" style="text-decoration:none;" onClick="window.open('http://twitter.com/home?status=<?php echo urlencode($article->title) . ' - ' . urlencode($article->source->title) . ' ' . $article->getUrl(); ?> via @BeTopular','sharer','toolbar=0,status=0,width=580,height=325');" href="javascript: void(0)">
						<i class="icon-twitter-sign"></i>
						<?php echo $article->retweets; ?>
					</a>
					<a class="linkedin-share" title="Share via LinkedIn" style="text-decoration:none;" href="javascript: void(0)">
						<i class="icon-linkedin-sign"></i>
						<?php echo $article->linkedin_shares; ?>
					</a>
				</span>
				 / 
				<span>
					<?php $saved = $article->isSaved(); ?>
					<a href="javascript: void(0)" class="topular-save-link <?php echo ($saved ? 'saved' : 'unsaved'); ?>" style="text-decoration:none;" rel="<?php echo $article->id; ?>">
						<?php if (!$saved): ?>
							<i class="icon-star"></i>
						<?php else: ?>
							<i class="icon-trash"></i>
						<?php endif; ?>
					</a>
				</span>
			</footer>
			
		</div>

	</div>

	<?php endforeach; ?>
</div>