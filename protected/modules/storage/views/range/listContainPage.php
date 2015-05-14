<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/js/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/common.js"></script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
    var oTable = $('.tableList').dataTable( {
            "oLanguage": {
           "sSearch": "Search all columns:"
       },
       	"iDisplayLength": 25,
       	"aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
       	'aoColumns' :[null, null, null, null, null, {'bSortable' : false}]    //disable column sort
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
});
</script>
<div class="clear">&nbsp;</div>
<table class="display stylized tableList" id="containList">
    <thead>
        <tr>
            <th>Contian ID</th>
            <th>Range</th>
            <th>Direction Of (Range)</th>
            <th>Column</th>
            <th>Cell</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php $row = 1; foreach ($contains as $key => $value): ?>
            <tr class="<?php echo ($key % 2) ? 'even' : 'odd' ?>  gradeA">
                <td width="100"><?php echo $value->contain_id ?></td>
                <td><?php echo $value->range->range_name ?></td>
                <td width="150"><?php echo $value->direction ?></td>
                <td width="150"><?php echo $value->column ?></td>
                <td><?php echo $value->cell ?></td>
                <td width="80"><?php echo CHtml::link(Yii::t('vi', 'View Floor'), $this->createUrl('/storage/floor/index', array('cid' => $value->contain_id)), array()) ?></td>
            </tr>
        <?php  $row++; endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th><input type="text" name="contain_id" value="Search Contain ID" class="search_init" /></th>
            <th><input type="text" name="rane_id" value="Search Range Name" class="search_init" /></th>
            <th><input type="text" name="direction" value="Search Direction" class="search_init" /></th>
            <th><input type="text" name="column" value="Search Column" class="search_init" /></th>
            <th><input type="text" name="cell" value="Search Cell" class="search_init" /></th>
            <th></th>
        </tr>
    </tfoot>
</table>

<div class="clear">&nbsp;</div>