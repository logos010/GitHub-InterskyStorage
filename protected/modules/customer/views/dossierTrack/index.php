<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/jquery.dataTables.js"></script>
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
	       	'aoColumns' :[null, null, null, null, null, null, null, null]    //disable column sort
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
<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/common.js"></script>
<style>
	#tbl_track .gradeA td {
		vertical-align: middle;
	}
</style>
<!-- Page title -->
<div id="pagetitle">
    <div class="wrapper">
        <h1 class="title"><?php echo $this->id; ?> Management</h1>
    </div>
</div>
<!-- Page content -->
<div id="page">
	<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'dossier-form',
			)); ?>
    <!-- Wrapper -->
    <div class="wrapper">
        <div id="breadcrumbs">
            <?php
            $this->widget('application.extensions.exbreadcrumbs.EXBreadcrumbs', array(
                    'links'=> array(
            			'Customer' => $this->createUrl('/customer/customer/index'),
            			'Track'
                    )
                ))
            ?>
        </div>
        <!-- Left column/section -->
        <section class="column width8 first">
        	 <div class="clear">&nbsp;</div>
				<div id="track">
					<table style="width: 100%">
							<tr id="sort-buttons">
								<td class="center" align="center">
									<strong style="font-size: 25px;"><?php echo CHtml::encode($companyName);?></strong>
								</td>
							</tr>
					</table>
					<!--SHOW DATA BEGIN-->
					<?php $count  	= count($arrTrack);?>
					<table class="display stylized tableList" id="tbl_track">
						<thead>
							<tr id="sort-buttons">

								<th width="80" style="text-align: center;" id="dossier_name" class="">Box No</th>
								<th width="80" style="text-align: center;" id="company_name" class="">Seal No</th>
								<th width="" style="text-align: center;" id="dossier_name" class="">Box Name</th>
								<th width="80px;" style="text-align: center;" id="status" class="">Action</th>
								<th width="80px;" style="text-align: center;">Location</th>
								<th width="80px;" style="text-align: center;">Old Location</th>
								<th width="80px;" style="text-align: center;" id="create_time" class="">Logs Time</th>
								<th width="60px;" style="text-align: center;">User</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$firstRow	= true;
								foreach ($arrTrack as $track) :
									$arrAction = array(
										'1' => 'insert',
										'2'	=> 'update',
										'3' => 'delete',
										'4' => 'update',
										'5'	=> 'withdrew',
										'6' => 'deposit',
									);
							?>
							<tr class="gradeA">
								<td class=""><?php echo CHtml::encode($track->dossier->dossier_no);?></td>
								<td class=""><?php echo CHtml::encode($track->dossier->seal_no);?></td>
								<td class=""><?php echo CHtml::encode($track->dossier->dossier_name);?></td>
								<td class="center"><?php echo $arrAction[$track->status];?></td>
								<td class="center"><?php if ($track->new_location != "") :?><span class = "label <?php if ($track->status == '5') { echo 'label-red';} elseif ($track->status == '3') {echo 'label-silver';} else {echo 'label-blue';};?>"><?php echo CHtml::encode($track->new_location);?></span><?php else :?>&nbsp; <?php endif;?></td>
								<td class="center"><?php if ($track->old_location != "") :?><span class = "label label-silver"><?php echo CHtml::encode($track->old_location);?></span><?php else :?>&nbsp; <?php endif;?></td>
								<td class="center" style="line-height:15px;"><?php echo CHtml::encode(date("m/d/Y h:i:s", $track->create_time));?></td>
								<td class="center"><?php echo $track->user_name;?></td>
							</tr>
							<?php
								$firstRow = false;
								endforeach;
							?>
						</tbody>
						<tfoot>
					        <tr>
					            <th><input type="text" name="dossier_no" value="Box No" class="search_init" /></th>
					            <th><input type="text" name="seal_no" value="Seal No" class="search_init" /></th>
					          	<th><input type="text" name="dossier_name" value="Box Name" class="search_init" /></th>
					            <th><input type="text" name="action" value="Action" class="search_init" /></th>
					           	<th><input type="text" name="new_location" value="Location" class="search_init" /></th>
					           	<th><input type="text" name="old_location" value="Old Location" class="search_init" /></th>
					          	<th><input type="text" name="create_time" value="Create Time" class="search_init" /></th>
					            <th><input type="text" name="user_name" value="User" class="search_init" /></th>
					        </tr>
		    			</tfoot>
					</table>
					<!--SHOW DATA END-->
				</div>
        </section>
    </div>
    <!-- End of Wrapper -->
    <?php $this->endWidget(); ?>
</div>
<div>&nbsp;</div>
<!-- End of Page content -->
