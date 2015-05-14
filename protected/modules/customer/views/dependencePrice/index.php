<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'customer-form',
		)); ?>
<!-- Page title -->
<div id="pagetitle">
    <div class="wrapper">
        <h1 class="title">Service Use Management</h1>
    </div>
</div>
<!-- Page content -->
<div id="page">
    <!-- Wrapper -->
    <div class="wrapper">
        <div id="breadcrumbs">
            <?php
             if (Util::intersky_getUserRole() != 'Customer') {
	            $this->widget('application.extensions.exbreadcrumbs.EXBreadcrumbs', array(
	                    'homeLink' => (Util::intersky_getUserRole(Yii::app()->user->id) == 'Customer') ? CHtml::link('Home', $this->createUrl('customer/cutomerViewDossier/', array('id' => $_GET['id'])), array('class' => 'home')) : null,
	                    'links'=> array(
	                        'Customer' => (Util::intersky_getUserRole(Yii::app()->user->id) == 'Customer') ? $this->createUrl('customer/cutomerViewDossier/', array('id' => $_GET['id'])) : $this->createUrl('/customer/customer/index'),
	                        'Serivce Used'
	                    )
	                ));
             }
            ?>
        </div>

        <!-- Left column/section -->
        <div class="clear">&nbsp;</div>
        <section class="column width8 first">
        	<?php
                echo $this->renderPartial('_view', compact('objDependences', 'post' , 'companyName'));
            ?>
        </section>
    </div>
    <!-- End of Wrapper -->
</div>
<div>&nbsp;</div>
<!-- End of Page content -->
<?php $this->endWidget(); ?>