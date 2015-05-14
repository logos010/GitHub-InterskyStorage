
<?php $i=1; foreach ($floors as $key => $value): ?>
    <?php
        if ($i%4 == 0 && $value->contain->cell != 'S'):
            echo "<br/>";
            $i=1;
        endif;

        $quickViewStatus = null;

        if (in_array($value->status, array(1, 2))):   // filled dossier
            $storageDistribute = $value->distribute;
            if (!empty($storageDistribute->customer_dossier->attributes)) {
				$time = $storageDistribute->customer_dossier->create_time;
	            $quickViewStatus .= "Company: ".$storageDistribute->customer_dossier->customer->company_name . "\n";
	            $quickViewStatus .= "Dossier Name: ".$storageDistribute->customer_dossier->dossier_name . "\n";
	            $quickViewStatus .= "Created :".date("d-m-Y", strtotime($time));
            }
		endif;

		$statusClass = 'label-green';   // empty ==> 0
		if ($value->floor_id == $currentId && $value->floor_id != $oldId) :
			$statusClass = 'label-purple';
		elseif($value->status == 1):
            $statusClass = 'label-blue';
        elseif($value->status == 2):    //  withdrew dossier
            $statusClass = 'label-red';

        endif;
        
        //add quick tip for user quick see customer information
        $storageDistribute = $value->distribute;
        if (!empty($storageDistribute->customer_dossier->attributes)) {
                            $time = $storageDistribute->customer_dossier->create_time;
                $quickViewStatus .= "Company: ".$storageDistribute->customer_dossier->customer->company_name . "\n";
                $quickViewStatus .= "Dossier Name: ".$storageDistribute->customer_dossier->dossier_name . "\n";
                $quickViewStatus .= "Created :".date("d-m-Y", strtotime($time));
        }
?>
	<?php if ($selectDossier) :?>
		<?php $styleDisplay = (in_array($value->status, array(1, 2)) && $value->floor_id != $currentId && $value->floor_id != $oldId) ? 'disable-chose-floor' : ("chose-floor " . $statusClass);?>
    	<span style="cursor: pointer;" id="<?php echo $value->floor_id?>" onclick="choseFloor(this.id);" class="label <?php echo $styleDisplay ?>" title="<?php echo $quickViewStatus; ?>"><?php echo $value->location_code; ?></span>
	<?php else :?>
		<span class="label <?php echo $statusClass ?>" title="<?php echo $quickViewStatus; ?>"><?php echo $value->location_code; ?></span>
	<?php endif;?>
<?php $i++; endforeach; ?>
