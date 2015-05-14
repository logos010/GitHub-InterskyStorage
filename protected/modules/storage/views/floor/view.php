<?php
$this->breadcrumbs=array(
	'Floors'=>array('index'),
	$model->floor_id,
);

$this->menu=array(
	array('label'=>'List Floor', 'url'=>array('index')),
	array('label'=>'Create Floor', 'url'=>array('create')),
	array('label'=>'Update Floor', 'url'=>array('update', 'id'=>$model->floor_id)),
	array('label'=>'Delete Floor', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->floor_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Floor', 'url'=>array('admin')),
);
?>

<h1>View Floor #<?php echo $model->floor_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'floor_id',
		'floor_name',
		'contain_id',
		'sub_floor',
		'location_code',
		'range_id',
	),
)); ?>
