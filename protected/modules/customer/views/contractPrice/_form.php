<div class="form" style="margin-top: 20px;">
	<div class="box box-info">Fields with <span class="required">*</span> are required.</div>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'customer-form',
		'enableAjaxValidation'=>false,
	)); ?>
	<?php echo $form->hiddenField($model,'cus_id', array()); ?>
	<?php
		$arrTypeRange = array(
			'size'=>5,
			'class' => 'input-error',
		);
	?>
	<div class="form-row">
		<?php echo $form->labelEx($model,'contract_range', array('class' => 'required-error')); ?><br/>
		<span style="width: 60px;float: left;text-align: center;line-height: 26px;margin-left: 45px;">From</span>
		<?php echo $form->textField($model,'contract_range_fr', $arrTypeRange); ?>
		<span style="width: 60px;float: left;text-align: center;line-height: 26px;">To</span>
		<?php echo $form->textField($model,'contract_range_to', $arrTypeRange); ?>
		<?php echo $form->error($model,'contract_range', array('class' => 'message-error')); ?>
	</div>
	<div class="form-row">
		<?php echo $form->labelEx($model,'price', array('class' => 'required-error')); ?><br/>
		<?php echo $form->textField($model,'price', array('size'=>60,'maxlength'=>60, 'class' => 'input-error')); ?>
		<?php echo $form->error($model,'price', array('class' => 'message-error')); ?>
	</div>
	<div class="form-row">
		<?php echo $form->labelEx($model,'note', array('class' => 'required-error')); ?><br/>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>70)); ?>
		<?php echo $form->error($model,'note', array('class' => 'message-error')); ?>
	</div>
	<div class="row buttons form-row">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-green big')); ?>
		<?php echo ($model->isNewRecord) ? CHtml::resetButton('Reset', array('class' => 'btn btn-blue big')) : CHtml::button('Cancel', array('onClick' => 'window.location=\'' . $this->createUrl('/customer/contractprice/index', array('id' => $model->cus_id)) .'\';','class' => 'btn btn-blue big')); ?>
	</div>
	<div class="form-row">&nbsp;</div>
<?php $this->endWidget(); ?>
</div><!-- form -->