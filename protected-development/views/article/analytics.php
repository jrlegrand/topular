<?php
/* @var $this ArticleController */
/* @var $model Article */
?>

<h1>View Article #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'url',
		'bitly_url',
		'title',
		'image_url',
		'date_published',
		'source_id',
		'fb_likes',
		'fb_shares',
		'retweets',
		'linkedin_shares',
		'score',
		'rank',
		'movement_day',
		'movement_week',
		'movement_month',
		'trend',
		'age',
		'hidden',
		'timestamp',
	),
)); ?>

<h2>Article Analytics</h2>
<!--
<ul class="nav nav-tabs" id="my-tab">
	<li class="active"><a href="#article-retweets" data-toggle="tab">Retweets</a></li>
	<li><a href="#article-fb-likes" data-toggle="tab">Facebook Likes</a></li>
	<li><a href="#article-fb-shares" data-toggle="tab">Facebook Shares</a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane active" id="article-retweets">
		<h3>Retweets over time</h3>
		<div id="retweets-plot" style="width:800px;height:400px;"></div>
	</div>
	<div class="tab-pane" id="article-fb-likes">
		<h3>Facebook likes over time</h3>
		<div id="fb-likes-plot" style="width:800px;height:400px;"></div>
	</div>
	<div class="tab-pane" id="article-fb-shares">
		<h3>Facebook shares over time</h3>
		<div id="fb-shares-plot" style="width:800px;height:400px;"></div>
	</div>
</div>
-->
		<h3>Retweets <button data-type="retweets" class="btn btn-small btn-success dataUpdate">Poll for data</button></h3>
		<div id="retweets-plot" style="width:800px;height:400px;"></div>
		<h3>Facebook Likes <button data-type="fb_likes" class="btn btn-small btn-success dataUpdate">Poll for data</button></h3>
		<div id="fb_likes-plot" style="width:800px;height:400px;"></div>
		<h3>Facebook Shares <button data-type="fb_shares" class="btn btn-small btn-success dataUpdate">Poll for data</button></h3>
		<div id="fb_shares-plot" style="width:800px;height:400px;"></div>


<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/flot/jquery.flot.time.min.js" type="text/javascript"></script>
<script type="text/javascript">	
	var twitter_data = [ <?php echo $retweet_data ?> ];
	var fb_likes_data = [ <?php echo $fb_likes_data ?> ];
	var fb_shares_data = [ <?php echo $fb_shares_data ?> ];
	var options = {
				series: {
					color: '#0082cd',
					hoverable: true,
					lines: { show: true },
					points: { show: true }
				},
				xaxis: {
					mode: 'time',
					timeformat: '%m/%d/%Y %I:%M %P',
					timezone: 'browser',
					minTickSize: [ 10, 'minute' ],
				},
				yaxis: {
					tickDecimals: 0,
				},
				grid: {
					autoHighlight: true,
				}
			};
	$.plot($('#retweets-plot'), twitter_data, options);
	$.plot($('#fb_likes-plot'), fb_likes_data, options);
	$.plot($('#fb_shares-plot'), fb_shares_data, options);
	
	// Initiate a recurring data update
	$("button.dataUpdate").click(function () {
		var type = $(this).attr('data-type');
		var placeholder = '#'+type+'-plot';
		var url = 'http://topular.in/article/ajaxanalytics?id=<?php echo $model->id; ?>&type='+type;
		
		$(this).html('<i class="icon-spinner icon-spin"></i> Polling...');
		
		function fetchData() {

			function onDataReceived(series) {

				data = [ series ];
				$.plot(placeholder, data, options);
			}

			$.ajax({
				url: url,
				type: 'GET',
				dataType: 'json',
				success: onDataReceived
			});
			
			setTimeout(fetchData, 10000);

		}
		
		fetchData();

	});

</script>