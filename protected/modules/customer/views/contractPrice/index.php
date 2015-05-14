<!-- Page title -->
<div id="pagetitle">
    <div class="wrapper">
        <h1 class="title"><?php echo $this->id; ?> Management</h1>
    </div>
</div>
<!-- Page content -->
<div id="page">
	<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'contract-form',
			)); ?>
    <!-- Wrapper -->
    <div class="wrapper">
        <div id="breadcrumbs">
            <?php
            $this->widget('application.extensions.exbreadcrumbs.EXBreadcrumbs', array(
                    'links'=> array(
                        'Customer' => $this->createUrl('/customer/customer/index'),
                        'Contract'
                    )
                ))
            ?>
        </div>
        <!-- Left column/section -->
        <div class="clear">&nbsp;</div>
        <section class="column width8 first">
        	<?php
                echo $this->renderPartial('_view', compact('objCustomes', 'objContracts', 'objServices', 'post'));
            ?>
        </section>
    </div>
    <!-- End of Wrapper -->
    <?php $this->endWidget(); ?>
</div>
<div>&nbsp;</div>
<!-- End of Page content -->
