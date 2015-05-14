<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/js/jquery.blockUI.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/js/jquery.datepick.pack.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#DependencePrice_create_time').datepick(({dateFormat: 'dd/mm/yyyy'}));
	});
</script>
<style>
	span.label-green:HOVER {
	    background-color: #0085CC;
	}
	td span.disable-chose-floor {
		 background-color: #d1d1d1;
	}
</style>
<div class="form" style="margin-top: 20px;">
	<div class="box box-info">Fields with <span class="required">*</span> are required.</div>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'dependence-form',
		'enableAjaxValidation'=>false,
	)); ?>
	<div class="form-row" style="padding-left: 80px;">
		<strong style="font-size: 22px;"><?php echo $customer->company_name;?></strong> <strong style="color: #c4c4c4">company</strong>
	</div>
	<div class="form-row">
		<?php echo $form->labelEx($model,'service_id', array('class' => 'required-error')); ?><br/>
		<?php echo $form->dropDownList($model, 'service_id', $listService, array('empty' => '(Select a service)', 'class' => 'input-error'));?>
		<?php echo $form->error($model,'service_id', array('class' => 'message-error')); ?>
	</div>
	<div class="form-row">
		<?php echo $form->labelEx($model,'create_time', array('class' => 'required-error')); ?><br/>
		<?php echo $form->textField($model,'create_time',array('size'=>23,'maxlength'=>40, 'class' => 'input-error', 'readonly' => 'readonly')); ?>
		<?php echo $form->error($model,'create_time', array('class' => 'message-error')); ?>
	</div>
	<div class="row buttons form-row">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-green big')); ?>
		<?php echo ($model->isNewRecord) ? CHtml::resetButton('Reset', array('class' => 'btn btn-blue big')) : ""; ?>
	</div>
	<?php $this->endWidget(); ?>
	<div class="form-row">&nbsp;</div>

</div><!-- form -->
