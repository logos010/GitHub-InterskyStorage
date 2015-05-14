<!-- Page title -->
<div id="pagetitle">
    <div class="wrapper">
        <h1 class="title"><?php Yii::t('vi', 'Access Denied!') ?></h1>
    </div>
</div>
<!-- Page content -->
<div id="page">
    <!-- Wrapper -->
    <div class="wrapper">

        <!-- Left column/section -->
        <section class="column width8 first">
            <div class="clear">&nbsp;</div>
            <div class="box box-error"><?php echo Yii::t('vi', 'Access Denied!') ?></div>
            <div class="box box-error-msg">
                    <ol>
                            <li><?php echo Yii::t('vi', 'You have not role to access this page!') ?></li>
                    </ol>
            </div>
            <div class="clear">&nbsp;</div>
        </section>
    </div>
    <!-- End of Wrapper -->
</div>
<!-- End of Page content -->