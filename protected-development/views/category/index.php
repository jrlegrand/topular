<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle = 'Topular | List Category';

$categories = Category::model()->findAll();

foreach ($categories as $category): ?>
	<a href="<?php echo $this->createUrl('article/index', array('city'=>$city, 'category'=>strtolower($category->title))); ?>"><?php echo $category->title; ?></a><br>
<?php endforeach ?>
