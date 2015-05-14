<div id="pagetitle">
    <div class="wrapper">
        <h1 class="title"><?php echo Yii::t('vi', 'Registration Page'); ?></h1>
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
                        'Create User'
                    )
                ));
            ?>
        </div>

        <!-- Left column/section -->
        <section class="column width8 first">
            <h1><?php echo Yii::t('vi', 'Create User') ?></h1>

            <?php echo $this->renderPartial('/user/_registrationPage', array('model'=>$model, 'profile' => $profile)); ?>
        </section>
    </div>
    <!-- End of Wrapper -->
</div>
<!-- End of Page content -->