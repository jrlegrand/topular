<?php foreach($articles as $article): ?>
	<?php echo $this->renderPartial('//article/_view', array('article'=>$article)); ?>
<?php endforeach; ?>