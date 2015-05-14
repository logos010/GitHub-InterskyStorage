<?php
$this->breadcrumbs=array(
	'Contract Prices'=>array('index'),
	$model->contract_id,
);

$this->menu=array(
	array('label'=>'List ContractPrice', 'url'=>array('index')),
	array('label'=>'Create ContractPrice', 'url'=>array('create')),
	array('label'=>'Update ContractPrice', 'url'=>array('update', 'id'=>$model->contract_id)),
	array('label'=>'Delete ContractPrice', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->contract_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ContractPrice', 'url'=>array('admin')),
);
?>

<h1>View ContractPrice #<?php echo $model->contract_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'contract_id',
		'contract_code',
		'cus_id',
		'price',
		'create_time',
		'contract_flag',
		'note',
	),
)); ?>
