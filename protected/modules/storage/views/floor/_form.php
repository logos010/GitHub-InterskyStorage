<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'floor-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'floor_name'); ?>
		<?php echo $form->textField($model,'floor_name',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'floor_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contain_id'); ?>
		<?php echo $form->textField($model,'contain_id'); ?>
		<?php echo $form->error($model,'contain_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sub_floor'); ?>
		<?php echo $form->textField($model,'sub_floor',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'sub_floor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'location_code'); ?>
		<?php echo $form->textField($model,'location_code',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'location_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'range_id'); ?>
		<?php echo $form->textField($model,'range_id'); ?>
		<?php echo $form->error($model,'range_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->