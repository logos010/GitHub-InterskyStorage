<div id="pagetitle">
    <div class="wrapper">
        <h1 class="title">Storage Management</h1>
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
                        'Storage'
                    )
                ))
            ?>
        </div>

        <!-- Left column/section -->
        <section class="column width8 first">
            <?php
            ?>
            <div class="content-box corners">
                    <header>
                            <h3>Storage Information</h3>
                    </header>
                    <section>
                        <p>Information about storage</p>
                        <table class="no-style full">
                                <tbody>
                                        <tr>
                                            <td><b>Name:</b></td>
                                            <td class="ta-left"><?php echo $model->st_name ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Address</b></td>
                                            <td class="ta-left"><?php echo $model->st_address ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Phone</b></td>
                                            <td class="ta-left"><?php echo $model->st_phone ?></td>
                                        </tr>
                                        <tr>
                                            <td align="ta-left" colspan="2"><a href='<?php echo Yii::app()->createUrl('/storage/range/index') ?>'><?php echo Yii::t('vi', 'View Range') ?></a></td>
                                        </tr>
                                </tbody>
                        </table>
                    </section>
            </div>
        </section>
    </div>
    <!-- End of Wrapper -->
</div>
<!-- End of Page content -->
