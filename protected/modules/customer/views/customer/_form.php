<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/js/jquery.datepick.pack.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
	 $('#Customer_contract_time').datepick(({dateFormat: 'dd/mm/yyyy'}));
 });
</script>
<div class="form" style="margin-top: 20px;">
	<div class="box box-info">Fields with <span class="required">*</span> are required.</div>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'customer-form',
		'enableAjaxValidation'=>false,
	)); ?>

	<div class="clearFloat">
		<?php echo $form->labelEx($model,'company_name', array('class' => 'required-error')); ?><br/>
		<?php echo $form->textField($model,'company_name',array('size'=>60,'maxlength'=>40, 'class' => 'input-error')); ?>
		<?php echo $form->error($model,'company_name', array('class' => 'message-error')); ?>
	</div>
	<div class="form-row">
		<?php echo $form->labelEx($model,'contract_code', array('class' => 'required-error')); ?><br/>
		<?php echo $form->textField($model,'contract_code',array('size'=>60,'maxlength'=>40, 'class' => 'input-error')); ?>
		<?php echo $form->error($model,'contract_code', array('class' => 'message-error')); ?>
	</div>
	<div class="form-row">
		<?php echo $form->labelEx($model,'comp_address', array('class' => 'required-error')); ?><br/>
		<?php echo $form->textField($model,'comp_address', array('size'=>60,'maxlength'=>255, 'class' => 'input-error')); ?>
		<?php echo $form->error($model,'comp_address', array('class' => 'message-error')); ?>
	</div>
	<div class="form-row">
		<?php echo $form->labelEx($model,'comp_email', array('class' => 'required-error')); ?><br/>
		<?php echo $form->textField($model,'comp_email',array('size'=>60,'maxlength'=>255, 'class' => 'input-error')); ?>
		<?php echo $form->error($model,'comp_email', array('class' => 'message-error')); ?>
	</div>
	<div class="form-row">
		<?php echo $form->labelEx($model,'comp_phone', array('class' => 'required-error')); ?><br/>
		<?php echo $form->textField($model,'comp_phone',array('size'=>60,'maxlength'=>15, 'class' => 'input-error')); ?>
		<?php echo $form->error($model,'comp_phone', array('class' => 'message-error')); ?>
	</div>
	<div class="form-row">
		<?php echo $form->labelEx($model,'comp_fax', array('class' => 'required-error')); ?><br/>
		<?php echo $form->textField($model,'comp_fax',array('size'=>60,'maxlength'=>20, 'class' => 'input-error')); ?>
		<?php echo $form->error($model,'comp_fax', array('class' => 'message-error')); ?>
	</div>
	<div class="form-row">
		<?php echo $form->labelEx($model,'contract_time', array('class' => 'required-error')); ?><br/>
		<?php echo $form->textField($model,'contract_time',array('size'=>23,'maxlength'=>20, 'class' => 'input-error')); ?>
		<?php echo $form->error($model,'contract_time', array('class' => 'message-error')); ?>
	</div>
	<div class="row buttons form-row">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-green big')); ?>
		<?php echo ($model->isNewRecord) ? CHtml::resetButton('Reset', array('class' => 'btn btn-blue big')) : CHtml::button('Cancel', array('onClick' => 'window.location=\'' . $this->createUrl('/customer/customer/index') .'\';','class' => 'btn btn-blue big')); ?>
	</div>
	<div class="form-row">&nbsp;</div>
<?php $this->endWidget(); ?>

</div><!-- form -->