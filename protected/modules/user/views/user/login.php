
<?php if (Yii::app()->user->hasFlash('loginMessage')): ?>

    <div class="success">
        <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
    </div>

<?php endif; ?>

<div class="wrapper-login">
    <!-- Login form -->
    <section class="full">
        <?php echo CHtml::beginForm(); ?>

        <?php echo CHtml::errorSummary($model); ?>

        <div class="box box-info" style="margin: 10px 0px">Type Usernam & Password to login <span style="color: darkred; font-weight: bold">INTERSKY System</span></div>

        <p>
            <?php echo CHtml::activeLabelEx($model, 'username', array('class' => 'required')); ?>
            <?php echo CHtml::activeTextField($model, 'username', array('class' => 'full', 'id' => 'username')) ?>
        </p>

        <p>
            <?php echo CHtml::activeLabelEx($model, 'password'); ?>
            <?php echo CHtml::activePasswordField($model, 'password', array('class' => 'full', 'id' => 'password')) ?>
        </p>


            <p class="hint">
                <?php echo CHtml::link(UserModule::t("Lost Password?"), Yii::app()->getModule('user')->recoveryUrl); ?>
            </p>

        <p>
            <?php echo CHtml::activeCheckBox($model, 'rememberMe'); ?>
            <?php echo CHtml::activeLabelEx($model, 'rememberMe'); ?>
        </p>

        <p>
            <?php echo CHtml::submitButton(UserModule::t("Login"), array('class' => 'btn btn-green big')); ?>
        </p>

        <?php echo CHtml::endForm(); ?>

    </section>
    <!-- End of login form -->

</div>
<div class="clear"></div>

<?php
$form = new CForm(array(
            'elements' => array(
                'username' => array(
                    'type' => 'text',
                    'maxlength' => 32,
                ),
                'password' => array(
                    'type' => 'password',
                    'maxlength' => 32,
                ),
                'rememberMe' => array(
                    'type' => 'checkbox',
                )
            ),
            'buttons' => array(
                'login' => array(
                    'type' => 'submit',
                    'label' => 'Login',
                ),
            ),
                ), $model);
?>