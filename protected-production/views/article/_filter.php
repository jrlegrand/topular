<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */


$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'verticalForm',
)); ?>

			<div class="filter-bar">
			<?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				'type'=>'inverse',
				'toggle'=>'radio', // 'checkbox' or 'radio'
				'buttons'=>array(
					array('label'=>'New', 'htmlOptions'=>array('rel'=>'tooltip','title'=>'Newest articles from today')),
					array('label'=>'Top', 'htmlOptions'=>array('rel'=>'tooltip','title'=>'Top articles from the week')),
					array('label'=>'Hot', 'active'=>true, 'htmlOptions'=>array('rel'=>'tooltip','title'=>'Top articles from today')),
				),
			)); ?>
			</div>
			
			<div class="filter-bar">
			<?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				'type'=>'inverse',
				'toggle'=>'radio', // 'checkbox' or 'radio'
				'buttons'=>array(
					array('label'=>'Indie', 'active'=>true, 'htmlOptions'=>array('rel'=>'tooltip','title'=>'Only show independent sources')),
					array('label'=>'All', 'htmlOptions'=>array('rel'=>'tooltip','title'=>'Show all sources - including mainstream')),
				),
			)); ?>
			</div>
			
			<div class="filter-bar">
			<?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				'type'=>'inverse',
				'toggle'=>'radio', // 'checkbox' or 'radio'
				'buttons'=>array(
					array('icon'=>'icon-th', 'htmlOptions'=>array('rel'=>'tooltip','title'=>'View as tiles')),
					array('icon'=>'icon-reorder', 'active'=>true, 'htmlOptions'=>array('rel'=>'tooltip','title'=>'View as rows')),
				),
			)); ?>
			</div>
			
			<div>
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'label'=>'Submit',
				'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
				'size'=>null, // null, 'large', 'small' or 'mini'
			)); ?>
			</div>

<?php $this->endWidget(); ?>