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
<div class="clear">&nbsp;</div>

<table class="display stylized tableList" id="rangeList">
    <thead>
        <tr id="sort-buttons">
            <th>Range ID</th>
            <th>Range Name</th>
            <th width="150">Range Column</th>
            <th wisth="150">Pressed Wall</th>
            <th></th>
        </tr>
    </thead>
    <?php foreach ($ranges as $key => $value): ?>
        <tr class="<?php echo ($key % 2) ? 'even' : 'odd' ?>  gradeA">
            <td width="100"><?php echo $value->range_id ?></td>
            <td class="center"><?php echo $value->range_name ?></td>
            <td class="center"><?php echo $value->range_column ?></td>
            <td class="center"><?php echo $value->pressed_wall ? 'Yes' : 'No' ?></td>
            <td>
                <?php echo CHtml::link(Yii::t('vi', 'Edit'), $this->createUrl('/storage/range/update', array('rid' => $value->range_id)), array()); ?>
                <?php echo CHtml::link(Yii::t('vi', 'View Contain'), $this->createUrl('/storage/range/viewContainInRange', array('rid' => $value->range_id)), array()); ?>
            </td>
        </tr>
    <?php endforeach; ?>
        <tfoot>
            <tr>
                <th><input type="text" name="range_id" value="Search engines" class="search_init" /></th>
                <th><input type="text" name="range_name" value="Search browsers" class="search_init" /></th>
                <th><input type="text" name="range_column" value="Search platforms" class="search_init" /></th>
                <th class="fnSelectBox" align="center"></th>
            </tr>
    </tfoot>
</table>
<div class="clear">&nbsp;</div>

