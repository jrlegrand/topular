<div class="row article-wrapper">
	<div class="col-sm-9 col-xs-12">
		<div class="article-unit">

			<div class="tplr-breadcrumbs">
				<span>
					<a href="<?php echo $this->createUrl('article/index', array('city'=>$article->source->city->title)) ?>" title="<?php echo ucwords($article->source->city->title); ?>">
						<?php echo ucwords($article->source->city->title); ?>
					</a>
				</span>
				 > 
				<span>
					<a href="<?php echo $this->createUrl('article/index', array('city'=>$article->source->city->title, 'category'=>$article->source->category->title)) ?>" title="<?php echo ucwords($article->source->city->title); ?> <?php echo $article->source->category->title; ?>">
						<?php echo $article->source->category->title; ?>
					</a>
				</span>
			</div>

			
				<h1 class="article-title<?php echo ($route == 'view' ? ' large' : ''); ?>">
			<!--<a href="<?php //echo $this->createUrl('article/view', array('id'=>$article->id));?>" title="<?php echo $article->title; ?>">-->
			<a href="<?php echo ($route == 'view' ? $article->getUrl() : $this->createUrl('article/view', array('id'=>$article->id))); ?>" title="<?php echo stripslashes($article->title); ?>"<?php echo ($route == 'view' ? 'target="_blank"' : ''); ?>>

				<?php echo stripslashes($article->title); ?>
			</a>
				</h1>
			
			<div class="source-info<?php echo ($route == 'view' ? ' large' : ''); ?>">
				By 
				<span class="source-title">
					<a href="<?php echo $this->createUrl('source/view', array('id'=>$article->source->id)) ?>" title="<?php echo $article->source->title; ?>"><?php echo $article->source->title; ?></a>
				</span> 
				<span class="date-published">
					<!--<i class="icon-time"></i> -->
					<?php echo $article->timeSince($article->date_published); ?> 
				</span>
			</div>

			<?php if ($route != 'viewww'): ?>
				<p>
					<?php if (!empty($article->image_url) && $article->getSummary()): ?>
					<!--<a href="<?php //echo $this->createUrl('article/view', array('id'=>$article->id));?>">-->
					<a href="<?php echo $article->getUrl(); ?>" target="_blank">
						<img src="<?php echo $article->image_url; ?>" height="150" width="150" style="margin-left: 10px; margin-bottom: 10px;" class="img-thumbnail article-image pull-right" title="<?php echo stripslashes($article->title); ?>" />
					</a>
					<?php endif; ?>

					<?php echo $article->getSummary(); ?>	
				</p>
				
				<?php if (isset($article->word_count) && $article->word_count != 0): ?>
				<span class="word-count">
					<?php echo $article->word_count; ?> words &#183; <strong><a style="color: #000;" href="<?php echo $article->getUrl();?>" target="_blank">Continue reading on original site &#187;</a></strong>
				</span>
				<? endif; ?>
			<?php endif; ?>

			<!-- Admin tools -->
			<?php if (!Yii::app()->user->isGuest && Yii::app()->user->type === 'admin'): ?>
			<div class="article-admin-tools">
				<strong>
					Admin: 
				</strong>
				<!--
				<a href="javascript: void(0)" class="topular-remove-article" title="Hide Article">
					<i class="icon-eye-close"></i> Article
				</a>
				<a href="javascript: void(0)" class="topular-hide-image" title="Hide Image">
					<i class="icon-eye-close"></i> Image
				</a>
				-->
				<a href="<?php echo $this->createUrl('article/update', array('id'=>$article->id)) ?>" class="topular-update-article" title="Update Article">
					<i class="icon-wrench"></i> Update
				</a>
				<a href="<?php echo $this->createUrl('article/view', array('id'=>$article->id)) ?>" class="topular-view-article" title="View Article">
					<i class="icon-search"></i> View
				</a>
				<span class="label" title="<?php echo $article->id; ?>">
					ID
				</span>
			</div> <!-- admin tools -->

			<?php endif; ?>	
		</div> <!-- article-unit -->
	</div> <!-- col-md-9 -->

	<div class="col-sm-3 col-xs-12">

		<div class="score-unit">
			<div class="score-inner">
				<div class="col-sm-12 col-xs-4 overall">
					<div class="score-big-text"><?php echo $article->getScore($article->score); ?></div>
					<div class="score-small-text">Score</div>
				</div>
				
				<div class="col-sm-6 col-xs-4 tplr-share-btn">
					<a data-toggle="modal" href="<?php echo $this->createUrl('article/share', array('id'=>$article->id)); ?>" data-target="#modal-share">
						<div class="score-big-text">
							<i class="icon-arrow-up"></i>
						</div>
						<div class="score-small-text">
							Share
						</div>
					</a>
				</div>

				<?php $saved = $article->isSaved(); ?>

				<?php if (!$saved): ?>
				<div class="col-sm-6 col-xs-4">
					<a href="javascript: void(0);" data-id="<?php echo $article->id; ?>" class="tplr-save-btn unsaved">
						<div class="score-big-text">
							<i class="icon-star"></i>
						</div>
						<div class="score-small-text">
							Save
						</div>
					</a>
				</div>
				
				<?php else: ?>
				<div class="col-sm-6 col-xs-4">
					<a href="javascript: void(0);" data-id="<?php echo $article->id; ?>" class="tplr-save-btn saved">
						<div class="score-big-text">
							<i class="icon-trash"></i>
						</div>
						<div class="score-small-text">
							Unsave
						</div>
					</a>
				</div>
				<?php endif; ?>
				
				<div style="color: rgba(238, 238, 238, 0.75);">.</div>
			
				<!-- hidden-xs -->
				<div class="col-sm-12 hidden score-table">
					<table class="table table-condensed" style="margin-bottom: 10px;">
						<tr>
							<th>
								<i class="icon-facebook-sign"></i>
							</th>
							<th>
								<i class="icon-twitter-sign"></i>
							</th>
							<th>
								<i class="icon-linkedin-sign"></i>
							</th>
						</tr>
						<tr>
							<td>
								<?php echo $article->getScore($article->fb_likes + $article->fb_shares); ?>
							</td>
							<td>
								<?php echo $article->getScore($article->retweets); ?>
							</td>
							<td>
								<?php echo $article->getScore($article->linkedin_shares); ?>
							</td>
						</tr>
					</table>
					
					<div class="hidden">
					<div style="text-align: center;"><small><strong>Rank</strong></small></div>
					<table class="table table-condensed" style="margin-bottom: 10px;">
						<tr>
							<th>
								<a href="javascript: void(0);" style="color: #ccc;"><i class="icon-angle-left"></i></a>
							</th>
							<th>
								Overall
							</th>
							<th>
								<a href="javascript: void(0);" style="color: #ccc;"><i class="icon-angle-right"></i></a>
							</th>
						</tr>
						<tr>
							<td colspan="3" style="text-align: center;">
								<?php echo $article->rank; ?> / ??k
							</td>
						</tr>
					</table>
					</div>
				</div> <!-- hidden-xs -->

			</div> <!-- score-inner -->
		</div> <!-- score-unit -->
		
	</div> <!-- col-md-3 score -->
	
</div> <!-- article-wrapper -->
