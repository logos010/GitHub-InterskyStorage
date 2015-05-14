<div id="pagetitle">
    <div class="wrapper">
        <h1 class="title"><?php echo $this->id; ?> Management</h1>
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
                        'Range'
                    )
                ));
            ?>
        </div>

        <div class="clear">&nbsp;</div>
        <a class="btn" href="<?php echo Yii::app()->createUrl('/storage/range/create') ?>"><span class="icon icon-add">&nbsp;</span><?php echo Yii::t('vi', 'Add New Range') ?></a>

        <!-- Left column/section -->
        <section class="column width8 first">
            <?php
                echo $this->renderPartial('listRangePage', compact('ranges', 'pages', 'sort'));
            ?>
        </section>
    </div>
    <!-- End of Wrapper -->
</div>
<!-- End of Page content -->