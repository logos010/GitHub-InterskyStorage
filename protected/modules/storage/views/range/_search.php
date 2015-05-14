<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'range_id'); ?>
		<?php echo $form->textField($model,'range_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'range_name'); ?>
		<?php echo $form->textField($model,'range_name',array('size'=>40,'maxlength'=>40)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'storage_id'); ?>
		<?php echo $form->textField($model,'storage_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'floor'); ?>
		<?php echo $form->textField($model,'floor'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pressed_wall'); ?>
		<?php echo $form->textField($model,'pressed_wall'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->