<div id="pagetitle">
    <div class="wrapper">
        <h1 class="title">Contain Management</h1>
    </div>
</div>

<!-- Page content -->
<div id="page">
    <!-- Wrapper -->
    <div class="wrapper">
        <div id="breadcrumbs">
            <?php
            $this->widget('application.extensions.exbreadcrumbs.EXBreadcrumbs', array(
                    'links'=> array(
                        'Storage' => $this->createUrl('/storage/storage/index'),
                        'Range' => $this->createUrl('/storage/range/index'),
                        'Contain'
                    )
                ))
            ?>
        </div>

        <!-- Left column/section -->
        <section class="column width8 first">
            <div class="clear">&nbsp;</div>
            <a class='btn' href="<?php echo $this->createUrl('/storage/range/viewContainInSummary', array('rid' => $rid)) ?>"><?php echo Yii::t('vi', 'View Contains Of Range {range_name} In Summary', array('{range_name}' => $rangeModel->range_name)); ?></a>

            <?php
                $this->renderPartial('listContainPage', array('contains' => $contains));
            ?>
        </section>
    </div>
    <!-- End of Wrapper -->
</div>
<!-- End of Page content -->
