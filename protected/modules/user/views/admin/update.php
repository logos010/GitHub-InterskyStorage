<div id="pagetitle">
    <div class="wrapper">
        <h1 class="title"><?php echo Yii::t('vi', 'Update USer Page'); ?></h1>
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
                        'User' => $this->createUrl('/user/admin'),
                        'Update'
                    )
                ));
            ?>
        </div>

        <!-- Left column/section -->
        <section class="column width8 first">
            <h1><?php echo Yii::t('vi', 'Update User'); ?></h1>

            <?php echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile)); ?>
        </section>
    </div>
    <!-- End of Wrapper -->
</div>
<!-- End of Page content -->