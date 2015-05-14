
<h1>View Storage #<?php echo $model->storage_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'storage_id',
		'st_name',
		'st_address',
		'map',
		'st_phone',
		'contact_peolpe',
	),
)); ?>
