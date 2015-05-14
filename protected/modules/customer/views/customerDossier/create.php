<!-- Page title -->
<div id="pagetitle">
    <div class="wrapper">
        <h1 class="title">Box Create</h1>
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
            			'Customer' => $this->createUrl('/customer/customer/index'),
            			'Contract' => $this->createUrl('/customer/contractprice/index', array('id' => $model->cus_id)),
            			'Box' => $this->createUrl('/customer/customerdossier/index', array('id' => $model->cus_id)),
                        'Create'
                    )
                ))
            ?>
        </div>

        <!-- Left column/section -->
        <section class="column width8 first">
           <?php echo $this->renderPartial('_form', compact('model', 'range', 'contains', 'oldFloorId')); ?>
        </section>
    </div>
    <!-- End of Wrapper -->
</div>
<!-- End of Page content -->