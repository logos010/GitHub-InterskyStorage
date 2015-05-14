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
                    'homeLink' => (Util::intersky_getUserRole(Yii::app()->user->id) == 'Customer') ? CHtml::link('Home', $this->createUrl('customer/cutomerViewDossier/', array('id' => $_GET['id'])), array('class' => 'home')) : null,
                    'links'=> array(
                        'Customer'
                    )
                ))
            ?>
        </div>

        <!-- Left column/section -->
        <div class="clear">&nbsp;</div>
        <a href="<?php echo $this->createUrl('/customer/customer/create');?>" class="btn"><span class="icon icon-add">&nbsp;</span>Create New Customer</a>
        <section class="column width8 first">
        	<?php
                echo $this->renderPartial('_view', compact('objCustomers'));
            ?>
        </section>
    </div>
    <!-- End of Wrapper -->
</div>
<div>&nbsp;</div>
<!-- End of Page content -->
<?php $this->endWidget(); ?>