<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('storage_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->storage_id), array('view', 'id'=>$data->storage_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('st_name')); ?>:</b>
	<?php echo CHtml::encode($data->st_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('st_address')); ?>:</b>
	<?php echo CHtml::encode($data->st_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('map')); ?>:</b>
	<?php echo CHtml::encode($data->map); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('st_phone')); ?>:</b>
	<?php echo CHtml::encode($data->st_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_peolpe')); ?>:</b>
	<?php echo CHtml::encode($data->contact_peolpe); ?>
	<br />


</div>