<!-- Page title -->
<div id="pagetitle">
    <div class="wrapper">
        <h1 class="title">Box Management</h1>
    </div>
</div>
<!-- Page content -->
<div id="page">
	<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'dossier-form',
			)); ?>
    <!-- Wrapper -->
    <div class="wrapper">
        <div id="breadcrumbs">
            <?php
            if (Util::intersky_getUserRole() != 'Customer') {
            	 $aLink = array(
            			'Customer' => $this->createUrl('/customer/customer/index'),
            			'Contract' => $this->createUrl('/customer/contractprice/index', array('id' => $_GET['id'])),
                        'Box'
                 );
            	 if (Util::intersky_getUserRole() == 'Staff') unset($aLink['Contract']);
            	 $this->widget('application.extensions.exbreadcrumbs.EXBreadcrumbs', array(
                    'links'=> $aLink,
                ));

            }

            ?>
        </div>
        <!-- Left column/section -->
        <div class="clear">&nbsp;</div>
        <?php if (Util::intersky_getUserRole() != 'Customer') :?>
        <a href="<?php echo $this->createUrl('/customer/customerdossier/create', array('id' => $_GET['id']));?>" class="btn"><span class="icon icon-add">&nbsp;</span>Create Box</a>
        <?php endif;?>
        <a href="<?php echo $this->createUrl('/customer/customerdossier/downloadCustomerDossierExcel', array('id' => $_GET['id']));?>" class="btn <?php echo (empty($arrDossiers)) ? "btn-sliver" : "btn-blue"?>" <?php echo (empty($arrDossiers)) ? "onClick = \"alert('Box not available!!!');return false;\"" : "";?>><?php echo Yii::t('vi', 'Download Box') ?></a>
        <section class="column width8 first">
        	<?php
                echo $this->renderPartial('_view', compact('arrDossiers', 'companyName'));
            ?>
        </section>
    </div>
    <!-- End of Wrapper -->
    <?php $this->endWidget(); ?>
</div>
<div>&nbsp;</div>
<!-- End of Page content -->
