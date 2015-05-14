<?php
$this->breadcrumbs=array(
	'Ranges'=>array('index'),
	$model->range_id,
);

$this->menu=array(
	array('label'=>'List Range', 'url'=>array('index')),
	array('label'=>'Create Range', 'url'=>array('create')),
	array('label'=>'Update Range', 'url'=>array('update', 'id'=>$model->range_id)),
	array('label'=>'Delete Range', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->range_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Range', 'url'=>array('admin')),
);
?>

<h1>View Range #<?php echo $model->range_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'range_id',
		'range_name',
		'storage_id',
		'floor',
		'pressed_wall',
	),
)); ?>
