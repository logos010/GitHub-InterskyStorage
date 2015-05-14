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
                        'Contain' => $this->createUrl('/storage/range/viewContainInRange', array('rid' => $_GET['cid'])),
                        'Floor'
                    )
                )) 
            ?>    
        </div>
        
        <!-- Left column/section -->
        <section class="column width8 first">
            <?php 
                $this->renderPartial('listFloorPage', array('floors' => $floors));
            ?>
        </section>
    </div>
    <!-- End of Wrapper -->
</div>
<!-- End of Page content -->
