<?php
	$userRole 	= Util::intersky_getUserRole();
	$userId		= Yii::app()->user->id;
?>
<section class="column width8 first">
    <div class="box box-info closeable">All fields are required</div>

    <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>

    <fieldset>
        <p>
            <?php echo $form->labelEx($model,'username'); ?><br/>
            <?php echo $form->textField($model,'username',array(
                'size'=>20,
                'maxlength'=>20,
                'disabled' => $model->isNewRecord ? 'false' : 'disabled',
                )); ?><br/>
            <?php echo $form->error($model,'username'); ?>
        </p>

        <p>
            <?php echo $form->labelEx($model,'password'); ?><br/>
            <?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128, 'value' => '')); ?><br/>
            <?php echo $form->error($model,'password'); ?>
        </p>

        <p>
            <?php echo $form->labelEx($model,'email'); ?><br/>
            <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?><br/>
            <?php echo $form->error($model,'email'); ?>
        </p>

        <?php if ($userRole == 'Administrator'): ?>
	       <?php if ($model->isNewRecord) :?>
		        <p>
		            <?php echo $form->labelEx($model,'superuser'); ?><br/>
		            <?php echo $form->dropDownList($model,'superuser',User::itemAlias('AdminStatus')); ?><br/>
		            <?php echo $form->error($model,'superuser'); ?>
		        </p>
	        <?php endif;?>
        <?php endif; ?>
        <?php if (($userRole == 'Administrator'  || $userRole == 'Staff') && $model->id != $userId): ?>
         	<p>
	            <?php echo $form->labelEx($model,'status'); ?><br/>
	            <?php echo $form->dropDownList($model,'status',User::itemAlias('UserStatus')); ?><br/>
	            <?php echo $form->error($model,'status'); ?>
	        </p>
		<?php endif;?>
        <?php if ($model->isNewRecord) :?>
        <p>
            <label>Role</label><br/>
            <select name="role">
                <option value="2">Staff</option>
                <option value="3">Customer</option>
            </select>
        </p>
        <?php endif; ?>

        <?php
		$profileFields=$profile->getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
        ?>
        <p>
            <?php echo $form->labelEx($profile,$field->varname); ?><br/>
            <?php
            if ($widgetEdit = $field->widgetEdit($profile)) {
                    echo $widgetEdit;
            } elseif ($field->range) {
                    echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
            } elseif ($field->field_type=="TEXT") {
                    echo CHtml::activeTextArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
            } else {
                    echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
            }
             ?><br/>
            <?php echo $form->error($profile,$field->varname); ?>
        </p>
        <?php
                }
            }
        ?>
        <p>
            <?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), array('class' => 'btn btn-green')); ?>
       		<?php echo ($model->isNewRecord) ? CHtml::resetButton('Reset', array('class' => 'btn btn-blue')) : CHtml::button('Cancel', array('onClick' => 'window.location=\'' . $this->createUrl('/user/admin') .'\';','class' => 'btn btn-blue')); ?>
        </p>
    </fieldset>

    <?php $this->endWidget(); ?>
</section>

