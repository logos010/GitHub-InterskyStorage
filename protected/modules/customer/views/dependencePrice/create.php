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
            			'Customer' 		=> $this->createUrl('/customer/customer/index'),
            			'Service Used' 	=> $this->createUrl('/customer/dependenceprice/index', array('id' => $_GET['id'])),
                        'Chose Service'
                    )
                ))
            ?>
        </div>

        <!-- Left column/section -->
        <section class="column width8 first">
           <?php echo $this->renderPartial('_form', compact('model', 'customer', 'listService')); ?>
        </section>
    </div>
    <!-- End of Wrapper -->
</div>
<!-- End of Page content -->