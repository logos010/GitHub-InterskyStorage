<div id="pagetitle">
    <div class="wrapper">
        <h1 class="title"><?php echo $this->id; ?></h1>
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
                        'Create'
                    )
                )) 
            ?>    
        </div>
        
        <!-- Left column/section -->
        <section class="column width6 first">
            <h1>Update Storage</h1>

            <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </section>
    </div>
    <!-- End of Wrapper -->
</div>
<!-- End of Page content -->