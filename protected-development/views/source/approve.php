<?php
/* @var $this SourceController */
/* @var $model Source */
$this->pageTitle = 'Topular | Approve Source';
?>
<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>false, // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true), // success, info, warning, error or danger
        ),
    )); ?>

<h1>Approve Sources</h1>
<p>These are user submitted sources that are awaiting admin approval.</p>

<table class="table table-striped table-hover table-condensed">
<thead>
	<th>ID</th>
	<th>Title</th>
	<th>Feed URL</th>
	<th>URL</th>
	<th>City</th>
	<th>Category</th>
	<th>Facebook</th>
	<th>Twitter</th>
	<th>User</th>
	<th>Date/time</th>
	<th>Tools</th>
</thead>
<tbody>
	<?php foreach ($model as $source): ?>
	<tr>
		<td><?php echo $source->id; ?></td>
		<td><?php echo $source->title; ?></td>
		<td><a href="<?php echo $source->feed_url; ?>" title="<?php echo $source->feed_url; ?>"><i class="icon-link"></i></a></td>
		<td><a href="<?php echo $source->url; ?>" title="<?php echo $source->url; ?>"><i class="icon-link"></i></a></td>
		<td><?php echo $source->city->title; ?></td>
		<td><?php echo $source->category->title; ?></td>
		<td><?php echo $source->facebook_handle; ?></td>
		<td><?php echo $source->twitter_handle; ?></td>
		<td><a href="<?php echo $this->createUrl('user/view', array('id'=>$source->user_id)); ?>" title="User <?php echo $source->user_id; ?>"><i class="icon-user"></i></a></td>
		<td><i title="<?php echo $source->timestamp; ?>" class="icon-time"></i> <?php echo date('n/j gA', strtotime($source->timestamp)); ?></td>
		<td>
			<a href="<?php echo $this->createUrl('source/approve', array('id'=>$source->id)); ?>" class="btn btn-success btn-small" title="Approve"><i class="icon-ok"></i></a>
			<!-- This delete button eventually needs to be AJAX otherwise it won't work -->
			<a href="<?php echo $this->createUrl('source/delete', array('id'=>$source->id)); ?>" class="btn btn-small" title="Decline"><i class="icon-remove"></i></a>
		</td>
	</tr>
	<?php endforeach; ?>
</tbody>
</table>