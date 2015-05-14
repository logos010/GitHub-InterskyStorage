<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8">
(function($) {
/*
 * Function: fnGetColumnData
 * Purpose:  Return an array of table values from a particular column.
 * Returns:  array string: 1d data array
 * Inputs:   object:oSettings - dataTable settings object. This is always the last argument past to the function
 *           int:iColumn - the id of the column to extract the data from
 *           bool:bUnique - optional - if set to false duplicated values are not filtered out
 *           bool:bFiltered - optional - if set to false all the table data is used (not only the filtered)
 *           bool:bIgnoreEmpty - optional - if set to false empty values are not filtered from the result array
 * Author:   Benedikt Forchhammer <b.forchhammer /AT\ mind2.de>
 */
$.fn.dataTableExt.oApi.fnGetColumnData = function ( oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty ) {
    // check that we have a column id
    if ( typeof iColumn == "undefined" ) return new Array();

    // by default we only want unique data
    if ( typeof bUnique == "undefined" ) bUnique = true;

    // by default we do want to only look at filtered data
    if ( typeof bFiltered == "undefined" ) bFiltered = true;

    // by default we do not want to include empty values
    if ( typeof bIgnoreEmpty == "undefined" ) bIgnoreEmpty = true;

    // list of rows which we're going to loop through
    var aiRows;

    // use only filtered rows
    if (bFiltered == true) aiRows = oSettings.aiDisplay;
    // use all rows
    else aiRows = oSettings.aiDisplayMaster; // all row numbers

    // set up data array
    var asResultData = new Array();

    for (var i=0,c=aiRows.length; i<c; i++) {
        iRow = aiRows[i];
        var aData = this.fnGetData(iRow);
        var sValue = aData[iColumn];

        // ignore empty values?
        if (bIgnoreEmpty == true && sValue.length == 0) continue;

        // ignore unique values?
        else if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;

        // else push the value onto the result data array
        else asResultData.push(sValue);
    }

    return asResultData;
}}(jQuery));


function fnCreateSelect( aData )
{
    var r='<select class="search_init"><option value=""></option>', i, iLen=aData.length;
    for ( i=0 ; i<iLen ; i++ )
    {
        r += '<option value="'+aData[i]+'">'+aData[i]+'</option>';
    }
    return r+'</select>';
}

var asInitVals = new Array();

$(document).ready(function() {
    var oTable = $('#floorList').dataTable( {
        "oLanguage": {
            "sSearch": "Search all columns:"
        },
        "iDisplayLength": 25,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
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
    } );

} );
</script>

<div class="clear">&nbsp;</div>

<table class="display stylized" id="floorList">
    <thead>
        <tr>
            <th>Floor ID</th>
            <th>Floor Name</th>
            <th>SubFloor</th>
            <th>Location Code</th>
            <th>Range Name</th>
            <th>Contain Number</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($floors as $key => $value): ?>
        <tr>
            <td><?php echo $value->floor_id ?></td>
            <td><?php echo $value->floor_name ?></td>
            <td><?php echo $value->sub_floor ?></td>
            <td><?php echo $value->location_code ?></td>
            <td><?php echo $value->range->range_name ?></td>
            <td><?php echo $value->contain_id ?></td>
            <td>
                <?php
                    if  ($value->status == 0):
                        echo CHtml::tag('span', array('class' => 'label label-green'), $value->location_code);
                    elseif ($value->status == 1):
                        echo CHtml::tag('span', array('class' => 'label label-blue'), $value->location_code);
                    elseif ($value->status == 2):
                        echo CHtml::tag('span', array('class' => 'label label-red'), $value->location_code);
                    endif;
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th><input type="text" name="floor_id" value="Search Floor ID" class="search_init" /></th>
            <th><input type="text" name="floor_name" value="Search Floor Name" class="search_init" /></th>
            <th><input type="text" name="sub_floor" value="Search Sub Floor" class="search_init" /></th>
            <th><input type="text" name="location_code" value="Search Location Code" class="search_init" /></th>
            <th><input type="text" name="range_id" value="Search Range ID" class="search_init" /></th>
            <th><input type="text" name="contain_id" value="Search Contain ID" class="search_init" /></th>
            <th><input type="text" name="status" value="Search Status" class="search_init" /></th>
        </tr>
    </tfoot>
</table>
<div class="clear">&nbsp;</div>