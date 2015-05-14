<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/js/tooltip.js"></script>
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
        var oTable = $('#containList').dataTable( {
            "oLanguage": {
                "sSearch": "Search all columns:"
            },
            "iDisplayLength": 8,
            "aLengthMenu": [[8, 50, 100, -1], [8, 50, 100, "All"]],
            "aaSorting": [ [1,'asc'], [3,'asc'], [0,'asc']],
            'aoColumns' :[null, null, null, null, null]    //disable column sort
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


        //        $("tfoot th").innerHTML = fnCreateSelect( oTable.fnGetColumnData(3) );
        //        $('select', this).change( function () {
        //            oTable.fnFilter( $(this).val(), 3 );
        //        } );

    } );
</script>
<div class="clear"></div><br/>
<?php
	$romanNumber 	= array('I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X');
	$sortContain	= array('E' => 0, 'N' => 1, 'W' => 2, 'S' => 3);
?>
<div>
    <fieldset>
        <legend><?php echo Yii::t('vi', 'Color Description') ?></legend>
        <span class="label label-green"><?php echo Yii::t('vi', 'Empty') ?></span>
        <span class="label label-blue"><?php echo Yii::t('vi', 'Filled') ?></span>
        <span class="label label-red"><?php echo Yii::t('vi', 'Withdrew') ?></span>
    </fieldset>
</div>
<div class="clear"></div>
<table class="display stylized" id="containList" style="margin-left: -7px;">
    <thead>
        <tr>
        	<th style="width: 1px;padding: 0px;border: 0px;visibility: hidden"></th>
            <th>Column</th>
            <th>Contain Name</th>
            <th>Direction</th>
            <th>Floors</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($contains as $key => $value): ?>
        <tr class="<?php echo ($key % 2) ? 'even' : 'odd' ?>  gradeA">
        	<td style="width: 1px;padding: 0px;border: 0px;background:#FFF"><span style="visibility: hidden"><?php echo $sortContain[$value->cell] ?></span></td>
            <td class="ta-justify ta-bold tahoma-font" width="80"><?php echo $romanNumber[($value->column) -1]; ?></td>

            <td class="note-font ta-justify"><?php echo $value->cell ?></td>
            <td class="ta-justify ta-bold"><?php echo $value->direction ?></td>
            <td><?php $this->widget('application.modules.storage.components.ContainFloorWidget', array('cid' => $value->contain_id, 'rid' => $value->range_id, 'currentId' => $currentId, 'oldId' => $oldId, 'selectDossier' => true)); ?></td>

        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
        	<th style="width: 1px;padding: 0px;border: 0px;visibility: hidden"></th>
            <th><input type="text" name="column" value="Search Column" class="search_init" /></th>
            <th><input type="text" name="cell" value="Search Cell Name" class="search_init" /></th>
            <th><input type="text" name="direction" value="Search Direction" class="search_init" /></th>

        </tr>
    </tfoot>
</table>

<link type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/custom.css" rel="stylesheet">