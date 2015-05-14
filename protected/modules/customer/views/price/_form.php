<div class="form" style="margin-top: 20px;">
	<div class="box box-info">Fields with <span class="required">*</span> are required.</div>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'customer-form',
		'enableAjaxValidation'=>false,
	)); ?>

	<div class="clearFloat">
		<?php echo $form->labelEx($model,'price_name', array('class' => 'required-error')); ?><br/>
		<?php echo $form->textField($model,'price_name',array('size'=>60,'maxlength'=>40, 'class' => 'input-error')); ?>
		<?php echo $form->error($model,'price_name', array('class' => 'message-error')); ?>
	</div>
	<div class="form-row">
		<?php echo $form->labelEx($model,'value', array('class' => 'required-error')); ?><br/>
		<?php echo $form->textField($model,'value', array('size'=>60,'maxlength'=>255, 'class' => 'input-error')); ?>
		<?php echo $form->error($model,'value', array('class' => 'message-error')); ?>
	</div>
	<div class="form-row">
		<?php echo $form->labelEx($model,'description', array('class' => 'required-error')); ?><br/>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>70, 'class' => 'required-error')); ?>
		<?php echo $form->error($model,'description', array('class' => 'message-error')); ?>
	</div>
	<div class="row buttons form-row">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-green big')); ?>
		<?php echo ($model->isNewRecord) ? CHtml::resetButton('Reset', array('class' => 'btn btn-blue big')) : ""; ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->