<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('#add_new_contract').click(function(){
			var url = $('#add_new_contract img').attr('alt');
			$(location).attr('href',url);
		});
		$('#add_new_service').click(function(){
			var url = $('#add_new_service img').attr('alt');
			$(location).attr('href',url);
		});
	});
</script>
<style>
table.stylized#tbl_contract th {
	background-color : #65b1b1 !important;
	border-color : #eeeeee;
	color : #555555;
}
table.stylized#tbl_service th {
	background-color : #d77a1e !important;
	border-color : #eeeeee;
	color : #555555;
}
#tbl_company {
	border-color : #fff5cc;
}
</style>
<div id="contract">
	<?php $count  	= count($objContracts);?>
	<!--SHOW DATA BEGIN-->
	<table class="display " id="tbl_company">
		<tbody>
			<tr id="sort-buttons">
				<td width="180px;" align="center" style="vertical-align:middle;background: #fff5cc" rowspan="<?php echo $count + 1;?>" class="">
					<strong><?php echo CHtml::encode($objCustomes->company_name);?></strong><br/>
					<mark><?php echo CHtml::encode($objCustomes->contract_code);?></mark>
					 <span style="border-left: 1px solid #b8e2fb;margin-left: 2px;">&nbsp;</span>
					 <?php if ($count > 0):?>
					<b><?php echo CHtml::link(Yii::t('vi', 'Box'), $this->createUrl('/customer/customerdossier/index', array('id' => $objContracts[0]->cus_id)), array()); ?></b>
					<?php else :?>
					<b><?php echo CHtml::link(Yii::t('vi', 'Box'), '#', array('onclick' => "alert('Please create contract for this user before!');return false;", 'class' => 'deactive'));?></b>
					<?php endif;?>
				</td>
				<td class="center" style="vertical-align: middle;padding: 2px;">
					<!--	Table Contract	-->
					<table class="display stylized" id="tbl_contract">
						<thead>
							<tr id="sort-buttons">
								<th class="center" style="vertical-align: middle;" width="60px;">Range</th>
								<th class="center" style="vertical-align: middle;" width="150px;">Price (VND)</th>
								<th class="center" style="vertical-align: middle;">Comment</th>
								<th class="center" style="vertical-align: middle;" width="80px;">Create Time</th>
								<th class="center" style="vertical-align: middle;text-align: center;" width="120px;" id="add_new_contract">
									<img alt="<?php echo $this->createUrl('/customer/contractprice/create', array('id' => $_GET['id']));?>" src="<?php echo Yii::app()->theme->baseUrl.'/images/add.png' ?>">
								</th>
							</tr>
						</thead>
						<tbody>
						 	<?php  if (!empty($objContracts)) :?>
							<?php foreach ($objContracts as $contract) :?>
							<tr class="gradeA">
								<td style="vertical-align: middle;" class="center"><strong><?php echo CHtml::encode($contract->contract_range);?></strong></td>
								<td style="vertical-align: middle;"><?php echo CHtml::encode(number_format($contract->price, 0, '', ' '));?></td>
								<td style="vertical-align: middle;"><?php echo CHtml::encode($contract->note);?></td>
								<td style="vertical-align: middle;" class="center"><?php echo CHtml::encode(date("d/m/Y", $contract->create_time));?></td>
								<td style="vertical-align: middle;" class="center">
									<?php echo CHtml::link(Yii::t('vi', 'Edit'), $this->createUrl('/customer/contractprice/update', array('id' => $contract->contract_id)), array()); ?>
<!--									<?php echo CHtml::link(Yii::t('vi', 'Remove'), $this->createUrl('/customer/contractprice/delete', array('id' => $contract->contract_id)), array("onclick" => "return confirm('Are you sure you want to delere this contract!');")); ?>-->
								</td>
							</tr>
							<?php endforeach;?>
							<?php else:?>
								<tr class="odd"><td valign="top" colspan="5" class="center dataTables_empty">No contract available in table</td></tr>
							<?php endif;?>
						</tbody>
					</table>
					<!--	Table Service  -->
					<table class="display stylized full" id="tbl_service" style="padding: 2px;">
						<thead>
							<tr>
								<th class="center" style="vertical-align: middle;" width="240">Service Name</th>
								<th class="center" style="vertical-align: middle;" width="150px;">Price (VND)</th>
								<th class="center" style="vertical-align: middle;">Comment</th>
								<th class="center" style="vertical-align: middle;text-align: center;" width="120px;" id="add_new_service">
									<img alt="<?php echo $this->createUrl('/customer/serviceprice/create', array('id' => $_GET['id']));?>" src="<?php echo Yii::app()->theme->baseUrl.'/images/add.png' ?>">
								</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($objServices)) :?>
							<?php foreach ($objServices as $service) :?>
							<tr class="gradeA">
								<td style="vertical-align: middle;"><strong><?php echo CHtml::encode($service->service_name);?></strong></td>
								<td style="vertical-align: middle;"><?php echo CHtml::encode(number_format($service->price, 0, 3, ' '));?></td>
								<td style="vertical-align: middle;"><?php echo CHtml::encode($service->note);?></td>
								<td style="vertical-align: middle;" class="center">
									<?php echo CHtml::link(Yii::t('vi', 'Edit'), $this->createUrl('/customer/serviceprice/update', array('id' => $service->service_id)), array()); ?>
									<?php if($service->count_used > 0):?>
										<?php echo CHtml::link(Yii::t('vi', 'Remove'), "#", array("onclick" => "alert('Delete denied,service already uesed!');return false;", 'class' => 'deactive')); ?>
									<?php else:?>
										<?php echo CHtml::link(Yii::t('vi', 'Remove'), $this->createUrl('/customer/serviceprice/delete', array('id' => $service->service_id)), array("onclick" => "return confirm('Are you sure you want to delete this service!');")); ?>
									<?php endif;?>
								</td>
							</tr>
							<?php endforeach;?>
							<?php else:?>
								<tr class="odd"><td valign="top" colspan="4" class="center dataTables_empty">No service available in table</td></tr>
							<?php endif;?>
						</tbody>
					</table>
				</td>
			</tr>
	</table>
	<!--SHOW DATA END-->
</div>