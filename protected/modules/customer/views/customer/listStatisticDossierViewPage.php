<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8">
    (function($) {
        //select month and year statistic
        var month, year, cid;
        $("select#dossierStatisticMonth, select#dossierStatisticYear").change(function(){
            var month	= $("select#dossierStatisticMonth").val();
            var year 	= $("select#dossierStatisticYear").val();
            var cid 	= <?php echo isset($_GET['id']) ? intval($_GET['id']) : 0 ?>;
            var url		= $('#get_report').attr('href');

            // change monht and year for get report
            $('#get_report').attr('href', url.replace(/month\/\d+\/year\/\d+/, 'month/' + month + '/year/' + year));

            //hide log dossier
            $('div.dossier-track-view').fadeOut(1000);

            //begin ajax statistic
            var statisTable = $('#statisticDossierList').dataTable( {
                "bProssing" : true,
                "bDestroy" : true,
                "sAjaxSource" : "<?php echo $this->createUrl('/customer/customer/customerDossierStatistic/id/'); ?>"+"/"+cid+"/month/"+month+"/year/"+year,
                "aoColumns" : [
                    {"mDataProp" : "dossier_id"},
                    {"mDataProp" : "dossier_name"},
                    {"mDataProp" : "seal_no"},
                    {"mDataProp" : "location"},
                    {"mDataProp" : "note"},
                    {"mDataProp" : "create_time"},
                    {"mDataProp" : "update_time"},
                ],
                "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                    nRow.className = "gradeA odd";
                    return nRow;
                },
                "fnInitComplete": function(oSettings, json) {
                    if (this.fnGetNodes().length == 0) {
                        $('#get_report').removeClass('btn-blue btn-sliver');
                        $('#get_report').addClass('btn-sliver');
                        $('#get_report').attr('onClick', 'alert("Report Empty!!!");return false;');
                    }
                    else {
                        $('#get_report').removeClass('btn-blue btn-sliver');
                        $('#get_report').addClass('btn-blue');
                        $('#get_report').removeAttr('onClick');
                    }
                }
            } );
            statisTable.fnClearTable();
        });
    } );
</script>
<div>
    <fieldset>
        <legend><?php echo Yii::t('vi', 'Color Description') ?></legend>
        <span class="label label-blue"><?php echo Yii::t('vi', 'Filled') ?></span>
        <span class="label label-red"><?php echo Yii::t('vi', 'Withdrew') ?></span>
        <select name="dossierStatisticYear" id="dossierStatisticYear">
            <?php for ($i = 2010; $i <= 2020; $i++): ?>
                <?php $selected = ($i == date('Y')) ? 'selected' : ""; ?>
                <option value="<?php echo $i ?>" <?php echo $selected; ?>><?php echo Yii::t('vi', '{year}', array('{year}' => $i)); ?></option>
            <?php endfor; ?>
        </select>
        <select name="dossierStatisticMonth" id="dossierStatisticMonth">
            <?php for ($i = 1; $i <= 12; $i++): ?>
                <?php $selected = ($i == date('n')) ? 'selected' : ""; ?>
                <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo Yii::t('vi', '{month}', array('{month}' => (($i >= 10) ? $i : "0" . $i))); ?></option>
            <?php endfor; ?>
        </select>
        <?php if(Util::intersky_getUserRole() != 'Customer') :?>
        <a id="get_report" href="<?php echo $this->createUrl('/customer/customer/report', array('id' => $_GET['id'], 'month' => date('n'), 'year' => date('Y'))); ?>" class="btn <?php echo (empty($dossiers)) ? "btn-sliver" : "btn-blue" ?>" <?php echo (empty($dossiers)) ? "onClick = \"alert('Report Empty!!!');return false;\"" : ""; ?>><?php echo Yii::t('vi', 'Report') ?></a>
    	<?php endif;?>
    </fieldset>
</div>
<div class="clear"></div>
<!--SHOW DATA BEGIN-->
<table style="width: 100%">
    <tr id="sort-buttons">
        <td class="center" align="center">
            <strong style="font-size: 25px;"><?php echo CHtml::encode($companyName); ?></strong>
        </td>
    </tr>
</table>
<table class="display stylized" id="statisticDossierList">
    <thead>
        <tr>
            <th>Box ID</th>
            <th>Seal No</th>
            <th>Box Name</th>
            <th>Location</th>
            <th>Comment</th>
            <th>Create Time</th>
            <th>Update Time</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dossiers as $key => $value): ?>
            <tr class="<?php echo ($key % 2) ? 'even' : 'odd' ?>  gradeA">
                <td width="80"><?php echo $value->dossier_no; ?></td>
                <td width="80"><?php echo $value->seal_no; ?></td>
                <td><?php echo $value->dossier_name; ?></td>
                <td width="80">
                    <?php
                    if ($value->status == '0'):
                        echo CHtml::tag('span', array('class' => 'label label-silver'), "delete&nbsp;");
                    elseif ($value->floor->status == '1'):
                        echo CHtml::tag('span', array('class' => 'label label-blue'), $value->floor->location_code);
                    elseif ($value->floor->status == '2'):
                        echo CHtml::tag('span', array('class' => 'label label-red'), $value->floor->location_code);
                    endif;
                    ?>
                </td>
                <td><?php echo $value->note; ?></td>
                <td width="100"><?php echo date('d-m-Y', $value->create_time); ?></td>
                <td width="100"><?php echo ($value->status == '0') ? date('d-m-Y', $value->update_time) : "&nbsp;"; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th><input type="text" name="box_id" value="Box ID" class="search_init" /></th>
            <th><input type="text" name="seal_no" value="Seal No" class="search_init" /></th>
            <th><input type="text" name="box_name" value="Box Name" class="search_init" /></th>
            <th><input type="text" name="dossier_location" value="Location" class="search_init" /></th>
            <th><input type="text" name="dossier_note" value="Note" class="search_init" /></th>
            <th><input type="text" name="create_time" value="Create Time" class="search_init" /></th>
            <th><input type="text" name="update_time" value="Update Time" class="search_init" /></th>
        </tr>
    </tfoot>
</table>

<div class="clear"></div><br/><br/>

<div class="clear">&nbsp;</div>