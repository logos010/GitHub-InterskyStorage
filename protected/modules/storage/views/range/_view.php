<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('range_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->range_id), array('view', 'id'=>$data->range_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('range_name')); ?>:</b>
	<?php echo CHtml::encode($data->range_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('storage_id')); ?>:</b>
	<?php echo CHtml::encode($data->storage_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('floor')); ?>:</b>
	<?php echo CHtml::encode($data->floor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pressed_wall')); ?>:</b>
	<?php echo CHtml::encode($data->pressed_wall); ?>
	<br />


</div>