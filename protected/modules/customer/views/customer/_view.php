<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/common.js"></script>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('#view_log').click(function(){
			var url = $('#view_log img').attr('alt');
			$(location).attr('href',url);
		});
	    var oTable = $('.tableList').dataTable( {
	            "oLanguage": {
	           "sSearch": "Search all columns:"
	       },
	       	"iDisplayLength": 25,
	       	"aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
	       	'aoColumns' :[null, null, null, null, {'bSortable' : false}]    //disable column sort
	       } );
	    $("tfoot input").keyup( function () {
	        /* Filter on the column (the index) of this element */
	        oTable.fnFilter( this.value, $("tfoot input").index(this) );
	    } );

		/*
		* Support functions to provide a little bit of 'user friendlyness' to the textboxes in
		* the footer
		*/
		$("tfoot input").each( function (i) {
		    asInitVals[i] = this.value;
		} );

		$("tfoot input").focus( function () {
		    if ( this.className == "search_init" )
		    {
		        this.className = "";
		        this.value = "";
		    }
		} );

		$("tfoot input").blur( function (i) {
		    if ( this.value == "" )
		    {
		        this.className = "search_init";
		        this.value = asInitVals[$("tfoot input").index(this)];
		    }
		} );

		/* Add a select menu for each TH element in the table footer */
		$("tfoot th.fnSelectBox").each( function ( i ) {
		    this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(3) );
		    $('select', this).change( function () {
		        oTable.fnFilter( $(this).val(), i );
		    } );
		});
	} );
</script>
<style>
	#tbl_customer .gradeA td {
		vertical-align: middle;
	}
</style>
<div id="customer">
	<!--SHOW DATA BEGIN-->
	<?php $count  	= count($objCustomers);?>
	<table class="display stylized tableList" id="tbl_customer">
		<thead>
			<tr id="sort-buttons">
				<th id="company_name">Name</th>
<!--				<th width="70" id="contract_code">Code</th>-->
				<th id="comp_address">Address</th>
				<th id="comp_email">Email</th>
				<th width="60px;" id="comp_phone">Phone/Fax</th>
				<th width="95px;">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($objCustomers as $customers) :?>
			<tr class="gradeA">
				<td><?php echo CHtml::encode($customers->company_name);?></td>
<!--				<td><?php echo CHtml::encode($customers->contract_code);?></td>-->
				<td><?php echo CHtml::encode($customers->comp_address);?></td>
				<td><?php echo CHtml::encode($customers->comp_email);?></td>
				<td class="center"><?php echo CHtml::encode(number_format($customers->comp_phone, 0,  3, '.'))?><br/><?php echo CHtml::encode(number_format($customers->comp_fax, 0,  3, '-'));?></td>
				<td class="center">
					<?php echo CHtml::link(Yii::t('vi', 'Edit'), $this->createUrl('/customer/customer/update', array('id' => $customers->cus_id)), array()); ?>
                    <?php echo CHtml::link(Yii::t('vi', 'Statistic'), $this->createUrl('/customer/customer/CustomerDossierStatistic', array('id' => $customers->cus_id)), array("class" => "")); ?>
					<?php echo CHtml::link(Yii::t('vi', 'Track'), $this->createUrl('/customer/dossiertrack/index', array('id' => $customers->cus_id)), array()); ?>
					<br/>
					<?php 
                                            if (Util::intersky_getUserRole(Yii::app()->user->id) == 'Administrator'):
                                                echo CHtml::link(Yii::t('vi', 'Contract'), $this->createUrl('/customer/contractprice/index', array('id' => $customers->cus_id)), array('class' => (($customers->count_contract > 0) ) ? 'subtitle' : "deactive")); 
                                            endif;
                                        ?>
					<?php echo CHtml::link(Yii::t('vi', 'Service'), $this->createUrl('/customer/dependenceprice/index', array('id' => $customers->cus_id)), array('class' => (($customers->count_service > 0) ) ? 'subtitle' : "deactive")); ?>
					<?php if ($customers->count_contract > 0) :?>
						<?php echo CHtml::link(Yii::t('vi', 'Box'), $this->createUrl('/customer/customerdossier/index', array('id' => $customers->cus_id)), array("class" => (($customers->count_box > 0) ) ? 'subtitle' : "deactive")); ?>
                   <?php else :?>
						<?php echo CHtml::link(Yii::t('vi', 'Box'), '#', array('onclick' => "alert('Please create contract for this user before!');return false;", 'class' => 'deactive'));?>
					<?php endif;?>
				</td>
			</tr>
			<?php endforeach;?>
		</tbody>
		<tfoot>
	        <tr>
	            <th><input type="text" name="company_name" value="Search Company Name" class="search_init" /></th>
<!--	            <th><input type="text" name="contract_code" value="Search Company Name" class="search_init" /></th>-->
	            <th><input type="text" name="comp_address" value="Search Address" class="search_init" /></th>
	            <th><input type="text" name="comp_email" value="Search Email" class="search_init" /></th>
	            <th><input type="text" name="comp_phone" value="Search Phone" class="search_init" /></th>
	            <th></th>
	        </tr>
    	</tfoot>
	</table>
	<!--SHOW DATA END-->
</div>