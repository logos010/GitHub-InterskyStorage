<?php $userRole = Util::intersky_getUserRole();?>
<?php if($userRole != 'Customer') :?>
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
        var oTable = $('#userList').dataTable( {
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
        } );
    } );
</script>
<?php endif;?>
<div class="content-box corners" style="width: 60%;">
                    <header>
                        <h3><?php echo $profile->username;?> (<?php echo $profile->role->role_name;?>)</h3>
                    </header>
                    <section>
                    	<header>
                       		<h3>storage.intersky.com.vn</h3>
                   	 	</header>
                        <table class="no-style full">
                            <tbody>
                                <tr>
                                    <td><b>Full Name</b></td>
                                    <td class="ta-left"><?php echo $profile->profile->first_name . ' ' . $profile->profile->last_name;?></td>
                                </tr>
                                <tr>
                                    <td><b>Email</b></td>
                                    <td class="ta-left"><a href="mailto:tuantc@intersky.com.vn"><?php echo $profile->email;?></a></td>
                                </tr>
                                <tr>
                                    <td><b>Create Time</b></td>
                                    <td class="ta-left"><?php echo date('d/m/Y h:i:s', strtotime($profile->create_at)); ?></td>
                                </tr>
                                <tr>
                                    <td><b>Last Visit</b></td>
                                    <td class="ta-left"><?php echo date('d/m/Y h:i:s', strtotime($profile->lastvisit_at)); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center"><a class="btn" href="<?php echo $this->createUrl('update', array('id' => $profile->id)) ?>">Change Profile</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                </div>
<div class="clear">&nbsp;</div>
<?php if(Util::intersky_getUserRole() != 'Customer') :?>
<a href="<?php echo Yii::app()->createUrl('/user/registration'); ?>" class="btn"><span class="icon icon-add">&nbsp;</span><?php echo Yii::t('vi', 'Create user') ?></a>
<div class="clear">&nbsp;</div>
<table class="display stylized" id="userList">
    <thead>
        <tr>
        	<?php if($userRole != 'Customer') :?><th style="width: 10px;">No</th><?php endif;?>
            <th>User Name</th>
            <th>Email</th>
            <?php if($userRole != 'Customer') :?><th>Account Type</th><?php endif;?>
            <th>Registration Date</th>
            <th>Last Visit</th>
            <?php if($userRole != 'Customer') :?><th>Status</th><?php endif;?>
            <th></th>
        </tr>
    </thead>
    <tbody>
    	<?php $i = 1;?>
        <?php foreach ($users as $key => $value): ?>
        	<?php if ($value->id != Yii::app()->user->id) :?>
	            <tr class="gradeA">
	                <?php if($userRole != 'Customer') :?><td><?php echo $i ?></td><?php endif;?>
	                <td><?php echo $value->username ?></td>
	                <td width=""><?php echo $value->email ?></td>
	                 <?php if($userRole != 'Customer') :?><td><?php echo (isset($value->role)) ? $value->role->role_name : "";?></td><?php endif;?>
	                <td width="150"><?php echo date('d/m/Y h:i:s', strtotime($value->create_at)); ?></td>
	                <td><?php echo date('d/m/Y h:i:s', strtotime($value->lastvisit_at)); ?></td>
	                <?php if($userRole != 'Customer') :?><td><?php echo $value->status == 1 ? 'Active' : 'Deactive' ?></td><?php endif;?>
	                <td><a href="<?php echo $this->createUrl('update', array('id' => $value->id)) ?>">Edit</a></td>
	            </tr>
            <?php $i++;endif;?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <?php if($userRole != 'Customer') :?><th><input type="text" name="user_id" value="Search User ID" class="search_init" /></th><?php endif;?>
            <th><input type="text" name="user_name" value="Search User Name" class="search_init" /></th>
            <th><input type="text" name="email" value="Search Email" class="search_init" /></th>
             <?php if($userRole != 'Customer') :?><th><input type="text" name="role" value="Search Role" class="search_init" /></th><?php endif;?>
            <th><input type="text" name="registration_date" value="Search Registration" class="search_init" /></th>
            <th><input type="text" name="last_visit" value="Search Last Visit" class="search_init" /></th>
            <?php if($userRole != 'Customer') :?><th><input type="text" name="status" value="Search Status" class="search_init" /></th><?php endif;?>
        </tr>
    </tfoot>
</table>
<?php endif;?>
<div class="clear">&nbsp;</div>