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
        var oTable = $('#dossierList').dataTable( {
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
        } );
        
        //ajax log dossier track
        $("a.view-dossier-log").click(function(){
            var did = $(this).attr('id');
            //dataTable
            $("div.dossier-track-view").fadeIn(1000);
            
            var dossierTable = $('#dossierTrackList').dataTable( {
                "bProssing" : true,
                "bDestroy" : true,
                "sAjaxSource" : "<?php echo $this->createUrl('/customer/customer/customerDossierTrack/did/'); ?>"+"/"+did,
                "aoColumns" : [
                    {"mDataProp" : "track_id"},
                    {"mDataProp" : "dossier_id"},                    
                    {"mDataProp" : "dossier_name"},
                    {"mDataProp" : "status"},
                    {"mDataProp" : "command"},
                    {"mDataProp" : "create_time"}
                ],
                "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                  nRow.className = "gradeX odd";
                  return nRow;
                }
            } );
            dossierTable.fnClearTable();
        });
    } );
</script>
<div>
    <fieldset>
        <legend><?php echo Yii::t('vi', 'Color Description') ?></legend>
        <span class="label label-blue"><?php echo Yii::t('vi', 'Filled') ?></span>
        <span class="label label-red"><?php echo Yii::t('vi', 'Withdrew') ?></span>
    </fieldset>
</div>
<div class="clear"></div>

<table class="display stylized" id="dossierList">
    <thead>
        <tr>
            <th>Dossier ID</th>
            <th>Barcode</th>
            <th>Dossier Name</th>
            <th>Status</th>
            <th>Log</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach ($dossierModel as $key => $dossier):                                
        ?>
        <tr>
            <td width="120"><?php echo $dossier->dossier_id ?></td>
            <td width="120"><?php echo $dossier->barcode ?></td>
            <td><?php echo $dossier->dossier_name ?></td>
            <td width="100">
                <?php
                    $distributes = $dossier->storage_distribute;
                    $locationCode = null;
                    foreach ($distributes as $distribute):
                        $locationCode = $distribute->floor->location_code;
                    endforeach;
                    if ($dossier->status=1): 
                        echo CHtml::tag('span', array('class' => 'label label-blue'), $locationCode);
                    elseif ($dossier->status==2):
                        echo CHtml::tag('span', array('class' => 'label label-red'), $locationCode);
                    endif; 
                ?>
            </td>
            <td width="80">
                    <a href="javascript:void(0)" class="view-dossier-log" id="<?php echo $dossier->dossier_id ?>">View Log</a>
            </td>
        </tr>
        <?php
            endforeach; 
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th><input type="text" name="dossier_id" value="Search Dossier ID" class="search_init" /></th>
            <th><input type="text" name="barcode" value="Search Barcode" class="search_init" /></th>
            <th><input type="text" name="dossier_name" value="Search Direction Name" class="search_init" /></th>
            <th><input type="text" name="status" value="Search Status" class="search_init" /></th>
            <th></th>            
        </tr>
    </tfoot>
</table>

<div class="clear">&nbsp;</div>

<div class="dossier-track-view hide">
    <h2><?php echo Yii::t('vi', "Customer's dossier tracing log") ?></h2>
    <table class="display stylized" id="dossierTrackList">
        <thead>
            <tr>
                <th width="80">Track ID</th>
                <th width="80">Dossier ID</th>
                <th>Dossier Name</th>
                <th>Status</th>
                <th>Command</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
        <tfoot>
            
        </tfoot>
    </table>
</div>
<div class="clear">&nbsp;</div>