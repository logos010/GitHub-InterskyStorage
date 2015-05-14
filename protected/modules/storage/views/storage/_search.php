<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'storage_id'); ?>
		<?php echo $form->textField($model,'storage_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'st_name'); ?>
		<?php echo $form->textField($model,'st_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'st_address'); ?>
		<?php echo $form->textField($model,'st_address',array('size'=>25,'maxlength'=>25)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'map'); ?>
		<?php echo $form->textField($model,'map',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'st_phone'); ?>
		<?php echo $form->textField($model,'st_phone',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contact_peolpe'); ?>
		<?php echo $form->textField($model,'contact_peolpe',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->