<section class="column width8 first">
    <div class="box box-info">All fields are required</div>

    <!-- form start -->
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'storage-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));
    ?>

    <?php echo $form->errorSummary($model); ?>

        <fieldset>
            <p>
                <?php echo $form->labelEx($model, 'st_name'); ?><br/>
                <?php echo $form->textField($model, 'st_name', array('size' => 60, 'maxlength' => 255, 'class' => 'half', 'id' => 'st_name')); ?><br/>
                <?php echo $form->error($model, 'st_name'); ?>
            </p>

            <p>
                <?php echo $form->labelEx($model, 'st_address'); ?><br/>
                <?php echo $form->textField($model, 'st_address', array('size' => 25, 'maxlength' => 255)); ?><br/>
                <?php echo $form->error($model, 'st_address'); ?>            
            </p>

            <p>
                <?php echo $form->labelEx($model, 'map'); ?><br/>
                <?php echo $form->fileField($model, 'map', array()); ?><br/>
                <?php echo $form->error($model, 'map'); ?>
            </p>

            <p>
                <?php echo $form->labelEx($model, 'st_phone'); ?><br/>
                <?php echo $form->textField($model, 'st_phone', array('size' => 20, 'maxlength' => 20)); ?><br/>
                <?php echo $form->error($model, 'st_phone'); ?>
            </p>

            <p>
                <?php echo CHtml::label(Yii::t('vi', 'Name Of Contacter'), 'contact_peolpe_name'); ?><br/>
                <?php echo CHtml::textField('contact[name]', '',  array('size' => 60, 'maxlength' => 255)); ?><br/>
            </p>
            
            <p>
                <?php echo CHtml::label(Yii::t('vi', 'Phone Of Contacter'), 'contact_peolpe'); ?><br/>
                <?php echo CHtml::textField('contact[phone]', '', array('size' => 60, 'maxlength' => 255)); ?><br/>
            </p>

            <p>
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-green big')); ?>
            </p>
        </fieldset>

    <?php $this->endWidget(); ?>
        <!--End Form -->
</section>