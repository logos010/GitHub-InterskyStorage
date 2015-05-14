<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'floor_id'); ?>
		<?php echo $form->textField($model,'floor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'floor_name'); ?>
		<?php echo $form->textField($model,'floor_name',array('size'=>40,'maxlength'=>40)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contain_id'); ?>
		<?php echo $form->textField($model,'contain_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sub_floor'); ?>
		<?php echo $form->textField($model,'sub_floor',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'location_code'); ?>
		<?php echo $form->textField($model,'location_code',array('size'=>40,'maxlength'=>40)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'range_id'); ?>
		<?php echo $form->textField($model,'range_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->