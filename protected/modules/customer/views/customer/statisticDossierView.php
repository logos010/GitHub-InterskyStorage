<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/js/jquery.blockUI.js"></script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
        //select month and year statistic
        var month, year, cid;
        $("select#dossierStatisticMonth, select#dossierStatisticYear").change(function(){
            var month	= $("select#dossierStatisticMonth").val();
            var year 	= $("select#dossierStatisticYear").val();
            var cid 	= <?php echo isset($_GET['id']) ? intval($_GET['id']) : 0 ?>;
            var url     = $('#get_report').attr('href');

            // change month and year for get report
            $('#get_report').attr('href', url.replace(/month\/\d+\/year\/\d+/, 'month/' + month + '/year/' + year));

			var getUrl 	= "<?php echo $this->createUrl('/customer/customer/customerDossierStatistic/id/'); ?>" + "/" + cid + "/month/" + month + "/year/" + year;
            $.getJSON(getUrl, function(data) {
	            if (data['total'] == 0) {
	              $('#get_report').removeClass('btn-blue btn-sliver');
	              $('#get_report').addClass('btn-sliver');
	              $('#get_report').attr('onClick', 'alert("Report Empty!!!");return false;');
	          	}
	          	else {
	              $('#get_report').removeClass('btn-blue btn-sliver');
	              $('#get_report').addClass('btn-blue');
	              $('#get_report').removeAttr('onClick');
	          	}
                $('#content_statistic').html(data['content']);
    		});
            $.blockUI();
        });
    } );
</script>
<div id="pagetitle">
    <div class="wrapper">
        <h1 class="title"><?php echo Yii::t('vi', 'Statistic For Box View') ?></h1>
    </div>
</div>

<!-- Page content -->
<div id="page">
    <!-- Wrapper -->
    <div class="wrapper">
        <div id="breadcrumbs">
            <?php
	            if (Util::intersky_getUserRole() != 'Customer') {
		            $this->widget('application.extensions.exbreadcrumbs.EXBreadcrumbs', array(
		                    'links'=> array(
		                        'Customer' => (Util::intersky_getUserRole(Yii::app()->user->id) == 'Customer') ? $this->createUrl('customer/cutomerViewDossier/', array('id' => $_GET['id'])) : $this->createUrl('/customer/customer/index/'),
		                        'Statistic Box'
		                    )
		                ));
	            }
            ?>
        </div>

        <!-- Left column/section -->
        <section class="column width8 first">
        	<div>
			    <fieldset>
			        <select name="dossierStatisticYear" id="dossierStatisticYear">
			            <?php for ($i = 2010; $i <= 2020; $i++): ?>
			                <?php $selected = ($i == date('Y')) ? 'selected' : ""; ?>
			                <option value="<?php echo $i ?>" <?php echo $selected; ?>><?php echo Yii::t('vi', '{year}', array('{year}' => $i)); ?></option>
			            <?php endfor; ?>
			        </select>
			        <select name="dossierStatisticMonth" id="dossierStatisticMonth">
			            <?php for ($i = 1; $i <= 12; $i++): ?>
			                <?php $selected = ($i == date('n')) ? 'selected' : ""; ?>
			                <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo Yii::t('vi', '{month}', array('{month}' => (($i >= 10) ? $i : "0" . $i))); ?></option>
			            <?php endfor; ?>
			        </select>
			        <?php if(Util::intersky_getUserRole() != 'Customer') :?>
			        <?php 
                                    $allowReportButton = "style='display:inline'";
                                    $emptyReport = (empty($model['service']) && $model['boxFull']['amount'] == 0 && $model['boxHalf']['amount'] == 0);
                                ?>
                                <?php else: $allowReportButton = "style='display:none'"; endif;?>
			        <a id="get_report" <?php echo $allowReportButton; ?> href="<?php echo $this->createUrl('/customer/customer/report', array('id' => $_GET['id'], 'month' => date('n'), 'year' => date('Y'))); ?>" class="btn <?php echo ($emptyReport) ? "btn-sliver" : "btn-blue" ?>" <?php echo ($emptyReport) ? "onClick = \"alert('Report Empty!!!');return false;\"" : ""; ?>><?php echo Yii::t('vi', 'Report') ?></a>
			    	                                
			    </fieldset>
			</div>
			<div class="clear"></div>
			<table style="width: 100%">
					    <tr id="sort-buttons">
					        <td class="center" align="center">
					            <strong style="font-size: 25px;"><?php echo CHtml::encode($model['companyNm']); ?></strong>
					        </td>
					    </tr>
					</table>
        	<div class="content-box corners" id="content_statistic">
                    <section>
                        <table class="no-style full" >
                        	<thead>
                        		<tr>
                        			<th></th>
                        			<th width="80" style="text-align: center;">Amount</th>
                        			<th width="100" style="text-align: center;">Price</th>
                        			<th width="100" style="text-align: center;">Total</th>
                        		</tr>
                        	</thead>
                            <tbody>
                                <tr>
                                    <td><b>Box storage full month</b></td>
                                    <td style="text-align: center;"><?php echo $model['boxFull']['amount']?></td>
                                    <td class="ta-right"><?php echo number_format($model['boxFull']['price'], 0,  3, '.');?></td>
                                    <td class="ta-right"><?php $totalFull = intval($model['boxFull']['price']) * intval($model['boxFull']['amount']); echo number_format($totalFull, 0,  3, '.');?></td>
                                </tr>
                                <tr>
                                    <td><b>Box storage half month</b></td>
                                   	<td style="text-align: center;"><?php echo $model['boxHalf']['amount']?></td>
                                    <td class="ta-right"><?php echo number_format($model['boxHalf']['price'], 0,  3, '.');?></td>
                                    <td class="ta-right"><?php $totalHalf = intval($model['boxHalf']['price']) * intval($model['boxHalf']['amount']);  echo number_format($totalHalf, 0,  3, '.');?></td>
                                </tr>
                                <?php $total = $totalFull + $totalHalf;?>
                                <?php foreach ($model['service'] as $service) : ?>
									<tr>
	                                    <td><b><?php echo ucfirst($service->name);?></b></td>
	                                   	<td style="text-align: center;"><?php echo $service->amount;?></td>
	                                    <td class="ta-right"><?php echo number_format($service->price, 0,  3, '.');?></td>
	                                    <td class="ta-right"><?php echo number_format($service->sum, 0,  3, '.');?></td>
                                	</tr>
                                <?php $total	= $total + intval($service->sum);?>
                                <?php endforeach;?>
                                <?php $vat 	= $total / 100 * 10; ?>
                                 <tr>
                                    <td colspan="3" class="ta-right">&nbsp;</td>
                                    <td class="ta-right"><b><?php echo number_format($total, 0,  3, '.');?></b></td>
                                </tr>
                                <tr>
                                	<td colspan="3" class="ta-right"><b>10% VAT</b></td>
                                    <td class="ta-right"><b><?php echo number_format($vat, 0,  3, '.');?></b></td>
                                </tr>
                                <tr>
                                	<td colspan="3" class="ta-right"><b>Total</b></td>
                                    <td class="ta-right"><mark><?php echo number_format(($total + $vat), 0,  3, '.');?></mark></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>

                </div>
            <?php //echo $this->renderPartial('listStatisticDossierViewPage', array('dossiers'=>$dossiers, 'companyName' => $companyName)); ?>
        </section>
    </div>
    <!-- End of Wrapper -->
</div>
<!-- End of Page content -->