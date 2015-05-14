<table class="no-style full">
    <tbody>
        <tr>
            <td align="center"><?php echo Yii::t('vi', 'User ID'); ?></td>
            <td align="center"><?php echo Yii::t('vi', 'User name'); ?></td>
            <td align="center"><?php echo Yii::t('vi', 'Login time'); ?></td>
        </tr>
<?php foreach ($lastVisited as $key => $value): ?>
    <tr>
        <td align="center">#<?php echo $value->id ?></td>
        <td align="center"><?php echo $value->profile->last_name." ".$value->profile->first_name; ?></td>
        <td align="center"><?php echo date("d/m/Y h:i:s", strtotime($value->lastvisit_at)) ?></td>
    </tr>
<?php endforeach; ?>
    </tbody>
</table>