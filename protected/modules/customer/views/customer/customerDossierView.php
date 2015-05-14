<div id="pagetitle">
    <div class="wrapper">
        <h1 class="title"><?php echo Yii::t('vi', 'Customer Dossier View') ?></h1>
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
                        'Dossier View'
                    )
                ));                    
            ?>    
        </div>

        <!-- Left column/section -->
        <section class="column width8 first">
            <h1><?php echo Yii::t('vi', 'Dossier List') ?></h1>

            <?php echo $this->renderPartial('listCustomerDossierViewPage', array('dossierModel'=>$dossierModel)); ?>
        </section>
    </div>
    <!-- End of Wrapper -->
</div>
<!-- End of Page content -->