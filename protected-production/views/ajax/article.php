<?php
/* @var $this AjaxController */
/* @var $data array */
?>
<article>
	<div class="article-tile">
		<a href="<?php echo $data['article_url']; ?>" title="<?php echo $data['article_title']; ?>">
			<img src="<?php echo $data['article_image']; ?>" />
			<h2><?php echo $data['article_title']; ?></h2>
		</a>
		
		<ul>
			<li><a href="#" title="<?php echo $data['source_title']; ?>"><?php echo $data['source_title']; ?></a></li>
			<li><?php echo $data['category_title']; ?></li>
			<li><?php echo $data['article_timestamp']; ?></li>
		</ul>

		<hr>
	</div>
</article>