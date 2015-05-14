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
	       	'aoColumns' :[null, null, null, null, null, null, null, {'bSortable' : false}]    //disable column sort
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
<div id="customer">
	<!--SHOW DATA BEGIN-->
	<table style="width: 100%">
			<tr id="sort-buttons">
				<td class="center" align="center">
					<strong style="font-size: 25px;"><?php echo CHtml::encode($companyName);?></strong>
				</td>
			</tr>
	</table>
	<table class="display stylized tableList">
		<thead>
			<tr id="sort-buttons">
				<th width="60px;">Box ID</th>
				<th width="72px;">Seal No</th>
				<th width="">Box Name</th>
				<th width="40px;">Location</th>
				<th width="150px;">Comment</th>
				<th width="72px;">Create Time</th>
				<th width="100px;">Destruction Time</th>
				<th width="<?php echo (Util::intersky_getUserRole() != 'Customer') ? "65" : "1";?>">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$firstRow	= true;
				foreach ($arrDossiers as $dossier) :
					$floor = $dossier->floor;
			?>
			<tr class="gradeA">
				<td><?php echo CHtml::encode($dossier->dossier_no);?></td>
				<td><?php echo CHtml::encode($dossier->seal_no);?></td>
				<td><?php echo CHtml::encode($dossier->dossier_name);?></td>
				<td class="center"><span class = "label <?php echo ($floor->status == '1' ? 'label-blue' : 'label-red')?>"><?php echo CHtml::encode($floor->location_code);?></span></td>
<!--				<td class="left"><?php //echo CHtml::encode($dossier->note);?></td>-->
                                <td class="left"><?php echo '<pre>'; echo CHtml::encode($dossier->note); echo '</pre>';?></td>
				<td class="center"><?php echo CHtml::encode(date("d/m/Y", $dossier->create_time));?></td>
				<td class="center"><?php echo CHtml::encode(date("d/m/Y", $dossier->destruction_time));?></td>

				<td class="center">
					<?php if(Util::intersky_getUserRole() != 'Customer') :?>
					<?php echo CHtml::link(Yii::t('vi', 'Edit'), $this->createUrl('/customer/customerdossier/update', array('id' => $dossier->dossier_id)), array()); ?>
					<?php echo CHtml::link(Yii::t('vi', 'Remove'), $this->createUrl('/customer/customerdossier/delete', array('id' => $dossier->dossier_id)), array("onclick" => "return confirm('Are you sure you want to delere this dossier!');")); ?>
					<?php endif;?>
				</td>
			</tr>
			<?php
				$firstRow = false;
				endforeach;
			?>
		</tbody>
		<tfoot>
	        <tr>
	        	<th><input type="text" name="dossier_no" value="Box ID" class="search_init" /></th>
	            <th><input type="text" name="seal_no" value="Seal No" class="search_init" /></th>
	        	<th><input type="text" name="dossier_name" value="Box Name" class="search_init" /></th>
	          	<th><input type="text" name="floor_id" value="Floor" class="search_init" /></th>
	            <th><input type="text" name="note" value="Comment" class="search_init" /></th>
	           	<th><input type="text" name="create_time" value="Create" class="search_init" /></th>
	          	<th><input type="text" name="destruction_time" value="Destruction" class="search_init" /></th>
				<th >&nbsp;</th>
	        </tr>
	    </tfoot>
	</table>
	<!--SHOW DATA END-->
</div>