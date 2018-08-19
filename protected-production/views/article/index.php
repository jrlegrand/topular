<?php
/* @var $this ArticleController */
/* @var $dataProvider CActiveDataProvider */ 

$this->pageTitle = $title . ' Top Local Social News | Topular';
?>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>false, // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'info'=>array('block'=>true, 'fade'=>true), // success, info, warning, error or danger
        ),
    )); ?>

<?php if ($this->route == 'article/search'): ?>
	<?php $menu = Article::getMenuList(); ?>
	<div id="search-options" style="margin-top:10px;">
		<form action="<?php echo $this->createUrl('article/search'); ?>">
			<div class="col-xs-12 col-sm-3">
				<label>Keyword</label>
				<input type="text" name="q" class="form-control" placeholder="Search" value="<?php echo (isset($_GET['q']) ? $_GET['q'] : ''); ?>">
			</div>
			<div class="col-xs-12 col-sm-3">
				<label>City</label>
				<select class="form-control" name="c">
					<option value="0">All Cities</option>
					<?php
					$city = (isset($_GET['c']) ? $_GET['c'] : 0);
					foreach ($menu['city'] as $c): ?>
						<option value="<?php echo $c['id']; ?>" <?php echo ($c['id'] == $city ? ' selected' : ''); ?>><?php echo ucwords($c['title']); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-xs-12 col-sm-3">
				<label>Timespan</label>
				<select class="form-control" name="t">
					<?php 
					$timespan = (isset($_GET['t']) ? strtolower($_GET['t']) : 'month');
					$timespans = array('day','week','month');
					foreach ($timespans as $t): ?>
						<option value="<?php echo $t; ?>" <?php echo ($t == $timespan ? ' selected' : ''); ?>><?php echo ucfirst($t); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-xs-12 col-sm-3" style="padding-top: 25px;">
				<button type="submit" class="btn btn-default btn-block">Submit</button>
			</div>
		</form>
	</div>
<?php endif; ?>
	
<?php echo $this->renderPartial('articles', array('articles'=>$articles)); ?>

<div class="hidden">
	<?php $this->widget('CLinkPager', array(
		'pages' => $pages,
	)) ?>
</div>
