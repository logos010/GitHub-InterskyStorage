<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/common.js"></script>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
	    var oTable = $('.tableList').dataTable( {
	            "oLanguage": {
	           "sSearch": "Search all columns:"
	       },
	       	"iDisplayLength": 25,
	       	"aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
	       	'aoColumns' :[null, null, null, {'bSortable' : false}]    //disable column sort
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
<div id="customer">
	<!--SHOW DATA BEGIN-->
	<?php $count  	= count($objPrices);?>
	<table class="display stylized tableList" id="tbl_customer">
		<thead>
			<tr id="sort-buttons">
				<th width="250px;">Price Name</th>
				<th width="150px">Price Value</th>
				<th class="center">Description</th>
				<th class="center" width="120px;"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($objPrices as $price) :?>
			<tr class="gradeA">
				<td class="<?php echo ($post['sortName'] == 'price_name') ? 'sorting_1' : "";?>"><?php echo CHtml::encode($price->price_name);?></td>
				<td class="<?php echo ($post['sortName'] == 'value') ? 'sorting_1' : "";?>"><?php echo CHtml::encode(number_format($price->value, 0, ',', '' ));?></td>
				<td><?php echo CHtml::encode($price->description);?></td>
				<td class="center">
					<?php echo CHtml::link(Yii::t('vi', 'Edit'), $this->createUrl('/customer/price/update', array('id' => $price->price_id)), array()); ?>
					<?php echo CHtml::link(Yii::t('vi', 'Remove'), $this->createUrl('/customer/price/delete', array('id' => $price->price_id)), array()); ?>
				</td>
			</tr>
			<?php endforeach;?>
		</tbody>
		<tfoot>
	        <tr>
	            <th><input type="text" name="price_name" value="Search Price Name" class="search_init" /></th>
	            <th><input type="text" name="value" value="Search Value" class="search_init" /></th>
	            <th><input type="text" name="description" value="Search Description" class="search_init" /></th>
	        </tr>
    	</tfoot>
	</table>
	<!--SHOW DATA END-->
</div>