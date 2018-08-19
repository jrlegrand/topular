<?php
/* @var $this SourceController */
/* @var $model Source */
$this->pageTitle = $model->title . ' | Topular'; ?>

<div class="col-xs-12">
	<h1><?php echo $model->title; ?></h1>
	<p><?php echo $model->city->title; ?> - <?php echo $model->category->title; ?></p>
	<div style="margin-bottom: 20px;">
		<?php $this->widget('bootstrap.widgets.TbDetailView', array(
			'type'=>'', // i.e. striped bordered condensed
			'data'=>$model,
			'attributes'=>array(
				array(
					'name'  => 'url',
					'value' => CHtml::link($model->title, $model->url, array('target'=>'_blank')),
					'type'  => 'raw',
					),
				'facebook_handle',
				'twitter_handle',
				array(
					'name'=>'city_id',
					'value'=>$model->city->title,
				),
				array(
					'name'=>'category_id',
					'value'=>$model->category->title,
				),
			),
		)); ?>
	</div>
</div>

<div class="col-xs-12">
	<h2>Article Counts</h2>
	<table class="table">
		<tr>
			<th>Today</th>
			<th>This Week</th>
			<th>This Month</th>
		</tr>
		<tr>
			<td><?php echo $model->getArticleCount('day'); ?></td>
			<td><?php echo $model->getArticleCount('week'); ?></td>
			<td><?php echo $model->getArticleCount('month'); ?></td>
		</tr>
	</table>
</div>

<div class="col-xs-12">
	<h2>Recent Articles</h2>
</div>

<?php
$articles = $model->getArticles('age',5);

echo $this->renderPartial('//article/articles', array('articles'=>$articles));
?>

<div class="col-xs-12" style="margin-bottom: 20px;">

</div>

<div class="col-xs-12">
	<h2>Top Articles</h2>
</div>
<?php
$articles = $model->getArticles('score',5);

echo $this->renderPartial('//article/articles', array('articles'=>$articles));
?>