<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/common.js"></script>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('.dependence_day').mouseover(function(){
			select_id = this.id;
			image_show = "#" + select_id + " img";
			$(image_show).show();
		});
		$('.dependence_day').mouseout(function(){
			select_id = this.id;
			image_show = "#" + select_id + " img";
			$(image_show).hide();
		});
		$('.dependence_delete').click(function(){
			var r = confirm('Are you sure you want to delere this choose service!');
			if (r) {
				var url = $(this).attr('alt');
				$(location).attr('href',url);
			}
		});
	    var oTable = $('#tbl_dependence').dataTable( {
	            "oLanguage": {
	           "sSearch": "Search all columns:"
	       },
	       	"iDisplayLength": 25,
	       	"aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
	       	'aoColumns' :[null, {'bSortable' : false,'bSearchable' : false}, null, null]    //disable column sort
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
<div id="dependence">
	<table class="display">
		<tr>
			<td>
				<?php echo  CHtml::dropDownList('year',$post['year'], $post['listYear'], array('empty'=>'-----------'));?>&nbsp;
				<?php 	echo  CHtml::dropDownList('month',$post['month'], $post['listMonth'], array('empty'=>'-----'));?>
				<input class="btn btn-green" type="submit" name="fiter_dependence" value="View Filter">

			</td>
			<td width="150px;">
                            <?php if(Util::intersky_getUserRole(Yii::app()->user->id) != 'Customer'): ?>
				<a href="<?php echo $this->createUrl('/customer/dependenceprice/create',  array('id' => $_GET['id']));?>" class="btn big"><span class="icon icon-add">&nbsp;</span>Choose Service</a>
                            <?php endif; ?>
			</td>
		</tr>

	</table>
	<table style="width: 100%">
			<tr id="sort-buttons">
				<td class="center" align="center">
					<strong style="font-size: 25px;"><?php echo CHtml::encode($companyName);?></strong>
				</td>
			</tr>
	</table>
	<!--SHOW DATA BEGIN-->
	<table class="display stylized" id="tbl_dependence" style="margin-top: 5px;">
		<thead>
			<tr id="sort-buttons">
				<th class="center" style="vertical-align: middle;">Service Name</th>
				<th class="center" style="vertical-align: middle;" width="60px;">Amount</th>
				<th class="center" style="vertical-align: middle;" width="150px;">Total Price (VND)</th>
				<th class="center" style="vertical-align: middle;" width="150px;">Day Use Service</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($objDependences as $dependence) :?>
			<tr class="gradeA">
				<td style="vertical-align: middle;"><strong><?php echo CHtml::encode($dependence['service_name']);?></strong></td>
				<td style="vertical-align: middle;" class="center"><?php echo CHtml::encode($dependence['amount']);?></td>
				<td style="vertical-align: middle;"><?php echo CHtml::encode(number_format($dependence['price'], 0, '', ' '));?></td>
                                <?php $dependence_day_class = Util::intersky_getUserRole(Yii::app()->user->id) != 'Customer' ? 'dependence_day' : ''; ?>
				<td style="vertical-align: middle;color: #006699;" class="<?php echo $dependence_day_class; ?>" id="dependence_day_<?php echo $dependence['service_id'];?>">
					<ul class="nostyle">
					<?php foreach($dependence['date'] as $date) :;?>
						<li>
							<?php echo date('d/m/Y', $date['create_time']);?>                                                        
							<img class="dependence_delete" style="display: none;cursor: pointer;" alt="<?php echo $this->createUrl('/customer/dependenceprice/delete', array('id' => $date['id']));?>" src="<?php echo Yii::app()->theme->baseUrl.'/images/delete.png' ?>">
						</li>
					<?php endforeach;?>
					</ul>
				</td>
			</tr>
			<?php endforeach;?>
		</tbody>
		<tfoot>
	        <tr>
	            <th><input type="text" name="service_name" value="Service Name" class="search_init" /></th>
	            <th><input type="text" name="amount" value="Amount" class="search_init" /></th>
	            <th><input type="text" name="total_price" value="Total Price" class="search_init" /></th>
	             <th>&nbsp;</th>
	        </tr>
    	</tfoot>
	</table>
	<!--SHOW DATA END-->
</div>