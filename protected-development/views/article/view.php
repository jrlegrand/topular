<?php
/* @var $this ArticleController */
/* @var $model Article */

$this->pageTitle = stripslashes($model->title) . ' | ' . $model->source->title . ' | Topular';
?>

<div style="margin-top: 20px;">
<?php
	echo $this->renderPartial('_view', array('article'=>$model, 'route'=>'view'));
?>
</div>

<div class="col-xs-12" style="text-align:center;margin-bottom:2px;">
	<a class="btn btn-default btn-block" href="<?php echo $model->getUrl(); ?>" target="_blank" title="" style="color:#000;font-weight:bold;"><i class="icon-share"></i> Link to original source</a>
</div>

<!--
<div class="col-xs-12" style="margin: 0; padding: 0;">
	<iframe style="height: 600px; width: 100%; border: 2px black solid; background: #ffffff;" frameborder="0" src="<?php //echo $model->url; ?>"></iframe>
</div>
-->

<div class="col-xs-12">
	<p><small>This awesome article was not written or created in any way by Topular.  <strong><?php echo $model->title; ?></strong> was originally and beautifully written by <a href="<?php echo $model->source->url; ?>" target="_blank"><strong><?php echo $model->source->title; ?></strong></a>. Please feel free to view this article on the <a href="<?php echo $model->getUrl(); ?>" target="_blank"><strong>original site</strong></a>.</small></p>
</div>

<div class="col-xs-12">
	<h1>More From <?php echo $model->source->category->title; ?></h1>
</div>
<?php
	echo $this->renderPartial('articles', array('articles'=>$category));
?>
<div class="col-xs-12">
	<h1>More From <?php echo $model->source->city->title; ?></h1>
</div>
<?php
	echo $this->renderPartial('articles', array('articles'=>$city));
?>