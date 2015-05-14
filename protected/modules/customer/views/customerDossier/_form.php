<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/js/jquery.blockUI.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/js/jquery.datepick.pack.js"></script>
<script type="text/javascript">
<!--
function showRangeBox() {
	$("#range").show();
}
 function showContain(value) {
	$('#dossier-form').submit();
	if (value != "") {
		$.blockUI();
	}

 }
 $(document).ready(function(){
	 $('#CustomerDossier_create_time').datepick(({dateFormat: 'dd/mm/yyyy'}));
	 $('#CustomerDossier_destruction_time').datepick(({dateFormat: 'dd/mm/yyyy'}));
 });
//-->
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
		'id'=>'dossier-form',
		'enableAjaxValidation'=>false,
	)); ?>
	<div class="form-row" style="padding-left: 80px;">
		<strong style="font-size: 22px;"><?php echo $model->customer->company_name;?></strong>
	</div>
	<div class="form-row">
		<?php echo $form->labelEx($model,'dossier_no', array('class' => 'required-error')); ?><br/>
		<?php echo $form->textField($model,'dossier_no',array('size'=>60,'maxlength'=>40, 'class' => 'input-error')); ?>
		<?php echo $form->error($model,'dossier_no', array('class' => 'message-error')); ?>
	</div>
	<div class="form-row">
		<?php echo $form->labelEx($model,'seal_no', array('class' => 'required-error')); ?><br/>
		<?php echo $form->textField($model,'seal_no',array('size'=>60,'maxlength'=>40, 'class' => 'input-error')); ?>
		<?php echo $form->error($model,'seal_no', array('class' => 'message-error')); ?>
	</div>
	<div class="form-row">
		<?php echo $form->labelEx($model,'dossier_name', array('class' => 'required-error')); ?><br/>
		<?php echo $form->textField($model,'dossier_name',array('size'=>60,'maxlength'=>40, 'class' => 'input-error')); ?>
		<?php echo $form->error($model,'dossier_name', array('class' => 'message-error')); ?>
	</div>
	<div class="form-row">
		<?php echo $form->labelEx($model,'create_time', array('class' => 'required-error')); ?><br/>
		<?php echo $form->textField($model,'create_time',array('size'=>23,'maxlength'=>40, 'class' => 'input-error', 'readonly' => 'readonly')); ?>
		<?php echo $form->error($model,'create_time', array('class' => 'message-error')); ?>
	</div>
	<div class="form-row">
		<?php echo $form->labelEx($model,'destruction_time', array('class' => 'required-error')); ?><br/>
		<?php echo $form->textField($model,'destruction_time',array('size'=>23,'maxlength'=>40, 'class' => 'input-error', 'readonly' => 'readonly')); ?>
		<?php echo $form->error($model,'destruction_time', array('class' => 'message-error')); ?>
	</div>
	<div class="form-row">
		<?php echo $form->labelEx($model,'note', array('class' => 'required-error')); ?><br/>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>70, 'class' => 'required-error')); ?>
		<?php echo $form->error($model,'note', array('class' => 'message-error')); ?>
	</div>
	<div class="form-row">
		<?php
			$floorClass = "";
			if (trim($model->floor_name) != "") {
				if ($model->withdrew_dossier) {
					$floorClass = "class = 'label label-red'";
				}
				else {
					$floorClass = "class = 'label label-blue'";
				}
			}

		?>
		<?php echo $form->labelEx($model,'floor_id', array('class' => 'required-error')); ?>
		<span style="cursor: pointer;margin-left: 5px;" onclick="showRangeBox();" id="showFloor" <?php echo $floorClass;?>><?php echo $model->floor_name;?></span>
		<?php echo (!$model->isNewRecord) ? (CHtml::checkBox('withdrew_dossier', $model->withdrew_dossier)."withdrew dossier") : "";?>
		<br/>
		<?php echo $form->hiddenField($model,'floor_id',array('size'=>60,'maxlength'=>40, 'class' => 'input-error')); ?>
		<?php echo $form->error($model,'floor_id', array('class' => 'message-error')); ?>
	</div>
	<div class="form-row">
		<?php
			$cssShow =  (!empty($contains) || ($model->isNewRecord && empty($contains) && $model->floor_id == "")) ? "block" : "none";
			echo CHtml::dropDownList('range', $range['selectRange'], $range['listRange'], array('empty' => '(Select a range)', 'onchange' => 'showContain(this.value);', 'style' => 'display :' . $cssShow));
		?>
	</div>
	<div id="showTableFloor">
		<?php
			if (!empty($contains)) {
				$this->renderPartial('listContainSummaryPage', array('contains' => $contains, 'currentId' => $model->floor_id, 'oldId' => $oldFloorId));
			}
		?>
	</div>
	<div class="row buttons form-row">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-green big')); ?>
		<?php echo ($model->isNewRecord) ? CHtml::resetButton('Reset', array('class' => 'btn btn-blue big')) : CHtml::button('Cancel', array('onClick' => 'window.location=\'' . $this->createUrl('/customer/customerdossier/index', array('id' => $model->cus_id)) .'\';','class' => 'btn btn-blue big')); ?>
	</div>
	<?php $this->endWidget(); ?>
	<div class="form-row">&nbsp;</div>
	<input type="hidden" id="old_floor_id" value="<?php echo $oldFloorId;?>">
</div><!-- form -->
<script>
	function choseFloor(id){
		var currFloorId = $('#CustomerDossier_floor_id').val();
		var status = $("#withdrew_dossier").attr("checked");

		if (id != currFloorId) {
			var nodeName = $("#"+id).html();
			$("#showFloor").attr("onclick", "showRangeBox();");
			$("#showFloor").html(nodeName);

			if (status) {
				$("#showFloor").addClass("label label-red");
			}
			else {
				$("#showFloor").addClass("label label-blue");
			}


			$("#CustomerDossier_floor_id").val(id);
		}
		$("#showTableFloor").hide();
		$("#range").val('');
		$("#range").hide();
	}
	$(document).ready(function() {
		$('#withdrew_dossier').click(function(){
			 if ($(this).attr("checked")) {
				 $("#showFloor").css("background-color", "#df0000");
			 }
			 else {
				 $("#showFloor").css("background-color", "#0085cc");
			}
		});
	});
</script>