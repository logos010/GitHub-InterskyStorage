<section class="column width8 first">
    <div class="box box-info closeable">All fields are required</div>

    <!-- form start -->
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'range-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data')
            ));
    ?>

    <?php echo $form->errorSummary($model);?>

    <fieldset>
        <?php if ($model->isNewRecord): ?>
            <p>
                <?php echo CHtml::label(Yii::t('vi', 'How many ranges could like to build'), 'num_of_building_ranges'); ?><br/>
                <?php echo CHtml::textField('num_of_building_ranges', RANGE_NUMBER, array('size' => 40, 'maxlength' => 40)) ?>
                <span class="label label-green"><?php echo Yii::t('vi', 'Spectify number of range could build in system. Only numberic (0-9)'); ?></span>
                <br/>
                <?php echo $form->error($model, 'range_column'); ?>
            </p>
        <?php endif; ?>

        <p>
            <?php echo $form->labelEx($model, 'range_name'); ?> <br/>
            <?php echo $form->textField($model, 'range_name', array('size' => 40, 'maxlength' => 40)); ?><br/>
            <?php echo $form->error($model, 'range_name'); ?>
        <div id="advance_rang_name" class="hidden"></div>
        </p>

        <p>
            <?php echo $form->labelEx($model, 'floor'); ?><br/>
            <?php
            echo $form->checkBox($model, 'floor', array(
                'checked' => 'true',
                'disabled' => $model->isNewRecord ? 'false' : 'disabled'
            ));
            ?>
            <span class="label label-green"><?php echo Yii::t('vi', 'Auto create range Floor (N, E, W, S)'); ?></span>
            <br/>
            <?php echo $form->error($model, 'floor'); ?>
        </p>

        <p>
            <?php echo CHtml::label(Yii::t('vi', 'Range column contain'), 'range_column_contain'); ?><br/>
            <?php echo CHtml::textField('range_column_contain', RANGE_FLOOR_NUMBER, array(
                'size' => 40,
                'maxlength' => 40,
                'disabled' => $model->isNewRecord==1 ? 'false' : 'disabled'
                )) ?>
            <span class="label label-green"><?php echo Yii::t('vi', 'Total contain for each column in a range'); ?></span>
            <br/>
            <?php echo $form->error($model, 'range_column'); ?>
        </p>

        <p>
            <?php echo $form->labelEx($model, 'range_column'); ?><br/>
            <?php echo $form->textField($model, 'range_column', array(
                'size' => 40,
                'maxlength' => 40,
                'disabled' => $model->isNewRecord ? 'false' : 'disabled',
                'value' => RANGE_COLUMN)); ?>
            <span class="label label-green"><?php echo Yii::t('vi', 'Total columns for each range'); ?></span>
            <br/>
        </p>

        <p>
            <?php echo $form->labelEx($model, 'pressed_wall'); ?><br/>
            <?php echo $form->checkBox($model, 'pressed_wall', array(
                'value' => 1,
                'disabled' => $model->isNewRecord ? 'false' : 'disabled',
                )); ?>

        <?php if($model->isNewRecord || $model->pressed_wall): ?>
        <div id="press_wall_direction">
            <label for="press_wall_direction"><?php echo Yii::t('vi', 'Enter direction of Range'); ?></label><br/>
            <select name="range_direction" id="range_direction">
                <option value="L"><?php echo Yii::t('vi', 'LEFT'); ?></option>
                <option value="R"><?php echo Yii::t('vi', 'RIGHT'); ?></option>
            </select>
            <span class="label label-green"><?php echo Yii::t('vi', 'Enter "L" or "R" characters in direction field'); ?></span>
        </div>
		<?php endif;?>
        <?php echo $form->error($model, 'pressed_wall'); ?>
        </p>

        <p>
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </p>
    </fieldset>

    <?php $this->endWidget(); ?>
</section>

<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/custom.js" type="text/javascript"></script>
<script type="text/javascript">
    $().ready(function(){
        var newRecord = <?php echo $model->isNewRecord; ?>;

        $("div#press_wall_direction").hide();
        //if range doesn't pressed wall, display direction character
        $("input#Range_pressed_wall").click(function(){
            if(!$(this).attr("checked")){    //range pressed into the wall
                $("div#press_wall_direction").fadeOut(1000);
                //                $("div#press_wall_direction").show(2000);
            }else{
                $("div#press_wall_direction").fadeIn(1000);
            }
        });

        //show range name input fields
        $('#num_of_building_ranges, #range_column_contain, #Range_range_column').keyup(function(e)
        {
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
                if (this.id == 'num_of_building_ranges') {
                	 if (this.value  > 1) {
                     	$("#Range_pressed_wall").removeAttr('checked');
                     	$("div#press_wall_direction").fadeOut(10);
                    	 	$("#Range_pressed_wall").attr('disabled', 'disabled');
                    	}
                    	else {
                    		$("#Range_pressed_wall").removeAttr('disabled');
                    	}
                 }

        });
        $('#num_of_building_ranges, #range_column_contain, #Range_range_column').blur(function(e){
            if (this.id == 'num_of_building_ranges') {
            	if ($(this).val() >1){
                    var name = "<fieldset><legend>Input Range Name</legend>";
                    for (var i=0; i<this.value-1; i++){
                        name += "<label class='required'>Range Name</label><br/><input type='text' name='rang[name][]' size='60' /><br/>";
                    }
                    name += "</fieldset>";
                    $("div#advance_rang_name").html(name);
                    $("div#advance_rang_name").fadeIn(1000);
                }
                else {
                	$("div#advance_rang_name").html("");
                	$("div#advance_rang_name").fadeOut(100);
                }
            }
        	if (this.value < 1)
               this.value = '1';
        });

        //disable rangeColumn and range contain Column if there is update status
        if (!newRecord){ //if there are update status
            $("#range_column_contain").addAttr('disabled', 'disabled');
            $("#Range_range_column").addAttr('disabled', 'disabled');
            $("#Range_pressed_wall").addAttr('disabled', 'disabled');
        }else{
            $("#range_column_contain").removeAttr('disabled');
            $("#Range_range_column").removeAttr('disabled');
            $("#Range_pressed_wall").removeAttr('disabled');
        }

    });
</script>