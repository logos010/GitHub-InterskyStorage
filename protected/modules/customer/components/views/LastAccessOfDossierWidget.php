<table class="no-style full">
    <tbody>
        <tr>
            <td colspan="2" ><?php echo Yii::t('vi', 'Customer Name'); ?></td>
            <td>&nbsp;</td>
        </tr>
<?php foreach ($customerDossiers as $key => $value): ?>
       <tr>
            <td colspan="2" class="ta-left">
                <a href="<?php echo Yii::app()->createUrl('customer/customerdossier/index/', array('id' => $value->cus_id)); ?> "><?php echo $customerRelative = $value->customer->company_name;?></a>
            </td>
            <td class="ta-right">
                    <?php
                        echo CHtml::link(Yii::t('vi', 'detail'), Yii::app()->createUrl('/customer/customer/lastAccessDossier/', array('id' => 1)));
                    ?>
            </td>
        </tr>
<?php endforeach; ?>
    </tbody>
</table>