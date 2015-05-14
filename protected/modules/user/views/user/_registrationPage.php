<?php
	Util::intersky_getExistedCustomerAccounts();
	$userRole = Util::intersky_getUserRole();
?>
<?php if(Yii::app()->user->hasFlash('registration')): ?>
<div class="box box-success">
    <?php echo Yii::app()->user->getFlash('registration'); ?>
</div>
<?php else: ?>

<section class="column width8 first">
    <div class="box box-info">All fields are required</div>

    <?php
    $form=$this->beginWidget('UActiveForm', array(
    'id' => 'registration-form',
    'enableAjaxValidation' => true,
    'disableAjaxValidationAttributes' => array('RegistrationForm_verifyCode'),
    'clientOptions' => array(
    'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>

    <p>
        <?php echo $form->labelEx($model, 'username'); ?><br/>
        <?php echo $form->textField($model, 'username', array('AUTOCOMPLETE' =>"off")); ?><br/>
        <?php echo $form->error($model, 'username'); ?>
    </p>

    <p>
        <?php echo $form->labelEx($model, 'password'); ?><br/>
        <?php echo $form->passwordField($model, 'password', array('AUTOCOMPLETE' =>"off")); ?><br/>
        <?php echo $form->error($model, 'password'); ?>
    </p>

    <p class="hint">
        <?php echo UserModule::t("Minimal password length 4 symbols."); ?>
    </p>

    <p>
        <?php echo $form->labelEx($model, 'verifyPassword'); ?><br/>
        <?php echo $form->passwordField($model, 'verifyPassword'); ?><br/>
        <?php echo $form->error($model, 'verifyPassword'); ?>
    </p>

    <p>
        <?php echo $form->labelEx($model, 'email'); ?><br/>
        <?php echo $form->textField($model, 'email'); ?><br/>
        <?php echo $form->error($model, 'email'); ?>
    </p>

    <p>
        <label>Role</label><br/>
        <select id="slRole" name="role">
            <?php if($userRole != 'Staff') :?><option value="2">Staff</option><?php endif;?>
            <option value="3">Customer</option>
        </select>
    </p>
    <p id="customer" class="<?php echo ($userRole != 'Staff') ? 'hidden' : ''?>">
        <label>Customer</label>
        <?php echo Util::intersky_getCusttomerList($userRole); ?>
    </p>

    <?php
        $profileFields=$profile->getFields();
        if ($profileFields) :
        foreach($profileFields as $field) :
    ?>
    <p>
        <?php echo $form->labelEx($profile, $field->varname); ?>
        <?php
            if ($widgetEdit = $field->widgetEdit($profile)) {
                echo $widgetEdit; echo "<br/>";
            } elseif ($field->range) {
                echo $form->dropDownList($profile, $field->varname, Profile::range($field->range)); echo "<br/>";
            } elseif ($field->field_type=="TEXT") {
                echo $form->textArea($profile, $field->varname, array('rows' => 6, 'cols' => 50)); echo "<br/>";
            } else {
                echo $form->textField($profile, $field->varname, array('size' => 60, 'maxlength' => (($field->field_size)?$field->field_size:255))); echo "<br/>";
            }
        ?>
    <?php echo $form->error($profile, $field->varname); ?>
    </p>
    <?php
        endforeach;
        endif;
    ?>

        <?php if (UserModule::doCaptcha('registration')): ?>
    <p>
        <?php echo $form->labelEx($model, 'verifyCode'); ?>

        <?php $this->widget('CCaptcha'); ?>
        <?php echo $form->textField($model, 'verifyCode'); ?>
        <?php echo $form->error($model, 'verifyCode'); ?>
    </p>

    <p class="hint"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
    <br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>
    <?php endif; ?>

    <p>
        <?php echo CHtml::submitButton(UserModule::t("Register"), array('class' => 'btn btn-green')); ?>
        <?php echo CHtml::button('Cancel', array('onClick' => 'window.location=\'' . $this->createUrl('/user/admin') .'\';','class' => 'btn btn-blue')); ?>
    </p>
<div class="clear"></div><br/>
<?php $this->endWidget(); ?>
</section>
<?php endif; ?>

<script type="text/javascript">
    $().ready(function(){
        $("select[name='role']").change(function(){
            if ($(this).val() == 3){
                $("p#customer").show(1000);
                $("select#customerListBox").removeAttr('disabled');
            }
            else{
                $("p#customer").hide(500);
                $("select#customerListBox").attr('disabled', 'disabled');
            }
        });
        $('#registration-form').submit(function(){
            if ($('#slRole').val() == '3' && $('#customerListBox').val() == 'empty') {
            	alert("Not exist customer for create user!!!");
            	return false;
            }
        });
    });
</script>
<div class="clear"></div>
