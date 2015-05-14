<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'customer-form',
		)); ?>
<!-- Page title -->
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
                        'Price' => $this->createUrl('/price/price/index'),
                    )
                ))
            ?>
        </div>

        <!-- Left column/section -->
         <div class="clear">&nbsp;</div>
        <a href="<?php echo $this->createUrl('/customer/price/create');?>" class="btn"><span class="icon icon-add">&nbsp;</span>Create new price</a>
        <section class="column width8 first">
        	<?php
               echo $this->renderPartial('_view', compact('objPrices'));
            ?>
        </section>
    </div>
    <!-- End of Wrapper -->
</div>
<div>&nbsp;</div>
<!-- End of Page content -->
<?php $this->endWidget(); ?>