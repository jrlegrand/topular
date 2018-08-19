<?php
/* @var $this ApiController */
/* @var $source Source */
?>
<style>

	.tplr-widget {
		background: #fff;
		width: 100%;
		height: 400px;
		overflow-y: scroll;
		overflow-x: hidden;
		margin:0;
		padding:5px;
	}
	
	.tplr-widget .widget-article {
		margin-bottom: 20px;
	}
	
	.tplr-widget-footer {
		background: #fff;
		padding: 5px;
		font-size: 13px;
		font-weight: bold;
	}
	
	.tplr-widget-footer a {
		text-decoration: none;
		color: #000;
	}

</style>

<div class="col-xs-5">
	<div class="tplr-widget">
		<h2>Top Stories</h2>
		<?php
		$source = $_GET['source'];
		$request_url = 'http://www.topular.in/index-test.php/api?source=' . $source;
		$json = file_get_contents($request_url);
		$result = json_decode($json);

		foreach ($result as $r) { ?>
			<div class="widget-article">
				<h1 class="article-title">
					<?php echo $r->title; ?>
				</h1>

				<div class="score-unit">
					<div class="score-inner">
						<div class="col-sm-12 col-xs-4 overall">
							<div class="score-big-text"><?php echo $r->score; ?></div>
							<div class="score-small-text">Score</div>
						</div>
						
						<div class="col-sm-12 col-xs-4 overall">
							<div class="score-big-text">123</div>
							<div class="score-small-text">Rank</div>
						</div>

						<div class="col-sm-6 col-xs-4 tplr-share-btn">
							<div class="score-big-text">
								<i class="icon-arrow-up"></i>
							</div>
							<div class="score-small-text">
								Share
							</div>
						</div>
					
						<div style="color: rgba(238, 238, 238, 0.75);">.</div>
					
					</div> <!-- score-inner -->
				</div> <!-- score-unit -->
			</div>
		<?php } ?>
	</div>
	<div class="tplr-widget-footer">
		<a href="http://topular.in" target="_blank">
			<img src="<?php echo Yii::app()->baseUrl; ?>/images/topular-logo-black-small.png" height="15"></img>
			Powered by Topular
		</a>
	</div>
</div> 