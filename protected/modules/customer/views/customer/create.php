<!-- Page title -->
<div id="pagetitle">
    <div class="wrapper">
        <h1 class="title"><?php echo $this->id; ?> Create</h1>
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
                        'Create'
                    )
                ))
            ?>
        </div>

        <!-- Left column/section -->
        <section class="column width8 first">
           <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </section>
    </div>
    <!-- End of Wrapper -->
</div>
<!-- End of Page content -->