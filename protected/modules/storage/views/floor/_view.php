<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('floor_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->floor_id), array('view', 'id'=>$data->floor_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('floor_name')); ?>:</b>
	<?php echo CHtml::encode($data->floor_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contain_id')); ?>:</b>
	<?php echo CHtml::encode($data->contain_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sub_floor')); ?>:</b>
	<?php echo CHtml::encode($data->sub_floor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('location_code')); ?>:</b>
	<?php echo CHtml::encode($data->location_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('range_id')); ?>:</b>
	<?php echo CHtml::encode($data->range_id); ?>
	<br />


</div>