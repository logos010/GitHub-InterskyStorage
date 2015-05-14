<?php if (Yii::app()->user->hasFlash('recoveryMessage')): ?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
    </div>
<?php else: ?>

    <div class="wrapper-login">
        <!-- Login form -->
        <section class="full">	        
            <h1><?php echo UserModule::t("Restore"); ?></h1>
            <?php echo CHtml::beginForm(); ?>

            <?php echo CHtml::errorSummary($form); ?>

            <div class="box box-info" style="margin: 10px 0px"><?php echo Yii::t('vi', "Please enter your login or email addres.") ?></div>
            <p>
                <?php echo CHtml::activeLabelEx($form, 'login_or_email'); ?>
                <?php echo CHtml::activeTextField($form, 'login_or_email') ?>
            </p>

            <p>
                <?php echo CHtml::submitButton(Yii::t('vi', "Restore"), array('class' => 'btn btn-green big')); ?>
            </p>

            <?php echo CHtml::endForm(); ?>
        </section>
    </div>

<?php endif; ?>