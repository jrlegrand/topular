<?php
/* @var $this UserController */
/* @var $model User */

$this->pageTitle = 'Topular | Saved Articles';
?>
<div class="col-xs-12">
	<h1>Saved Articles</h1>
</div>

<?php
//$articles = $model->articles(array('order'=>'`articles_articles`.`timestamp` DESC'));
$articles = $model->getRecentSavedArticles();

echo $this->renderPartial('//article/articles', array('articles'=>$articles));
?>