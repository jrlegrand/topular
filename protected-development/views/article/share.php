<?php
/* @var $this ArticleController */
/* @var $model Article */

?>

<h3><?php echo $model->title; ?></h3>
<p>By <strong><?php echo $model->source->title; ?></strong></p>
<p>Share this article via:</p>
<a class="btn btn-default btn-block twitter-share" href="javascript: void(0)" title="Share via Twitter" onClick="window.open('https://twitter.com/share?text=<?php echo urlencode($model->title) . ' by ' . urlencode($model->getTwitterHandle()) . ' ' . urlencode($model->getHashtag()) . '&url=' . urlencode($model->getUrl()); ?>','','toolbar=0,status=0,width=580,height=325');">
	<i class="icon-twitter"></i>
	Twitter
</a>
<a class="btn btn-default btn-block facebook-share" href="javascript: void(0)" title="Share via Facebook" onClick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($model->getUrl()); ?>','facebook-share-dialog','toolbar=0,status=0,width=580,height=325');">
	<i class="icon-facebook"></i>
	Facebook
</a>
<a class="btn btn-default btn-block linkedin-share" href="javascript: void(0)" title="Share via LinkedIn" onClick="window.open('http://www.linkedin.com/shareArticle?url=<?php echo urlencode($model->getUrl()); ?>&title=<?php echo urlencode($model->title) . ' - ' . urlencode($model->source->title); ?>&summary=Discovered via Topular: <?php echo urlencode($model->getSummary()); ?>','','toolbar=0,status=0,width=580,height=325');">
	<i class="icon-linkedin-sign"></i>
	 LinkedIn
</a>
<a class="btn btn-default btn-block email-share" href="mailto:?subject=Check out this article I found on Topular&body=<?php echo $model->title; ?> - <?php echo $model->getUrl(); ?> via Topular http://topular.in" title="Share via Email">
	<i class="icon-envelope"></i>
	 Email
</a>
<input style="margin-top:5px; text-align:center;" type="text" onfocus="this.select();"  class="form-control" value="<?php echo $model->getUrl(); ?>">
