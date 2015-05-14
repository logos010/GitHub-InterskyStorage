<?php $userNm = Util::getUserName();?>
<!-- Page title -->
<div id="pagetitle">
    <div class="wrapper">
        <h1>Dashboard</h1>
    </div>
</div>
<!-- End of Page title -->

<!-- Page content -->
<div id="page">
    <!-- Wrapper -->
    <div class="wrapper">
        <!-- Left column/section -->
        <section class="column width6 first">

            <div class="colgroup leading">
                <div class="column width3 first">
                    <h3>Welcome back, <a href="#"><?php echo $userNm; ?></a></h3>
                    <p>
                        <?php echo Yii::t('vi', 'Welcome to Intersky Storage Management System') ?><br/>                        
                    </p>
                </div>
                <div class="column width3">
                    <h4>Last login</h4>
                    <p>
                        <?php echo Yii::t('vi', 'Your last login time: <b>'. date("d/m/Y h:i:s", strtotime(Util::lastLoginTime(Yii::app()->user->id))).'</b>'); ?>
                    </p>
                </div>
            </div>

            <div class="colgroup leading">
            	<div class="column width3 first">
                    <h4><?php echo Yii::t('vi', 'Last access users') ?></h4>
                    <hr/>
                    <?php $this->widget('application.modules.storage.components.LastVisitedUserWidget'); ?>
                </div>
                <div class="column width3 ">
                    <h4><?php echo Yii::t('vi', 'Last access of box') ?></h4>
                    <hr/>
                    <table class="no-style full">
                        <tbody>
                            <tr>
                                <td><?php echo Yii::t('vi', 'Allow access'); ?></td>
                                <td class="ta-right"><?php echo Util::getEmptyFloor()."/".Util::getTotalFloorInStorage() ?></td>
                                <td><div id="progress1" class="progress full progress-green"><span><b></b></span></div></td>
                            </tr>
                            <tr>
                                <td><?php echo Yii::t('vi', 'Filled'); ?></td>
                                <td class="ta-right"><?php echo Util::getFilledFloor()."/".Util::getTotalFloorInStorage() ?></td>
                                <td><div id="progress2" class="progress full progress-blue"><span><b></b></span></div></td>
                            </tr>
                            <tr>
                                <td><?php echo Yii::t('vi', 'Withdrew'); ?></td>
                                <td class="ta-right"><?php echo Util::getWiddrewDossier()."/".Util::getTotalFloorInStorage() ?></td>
                                <td><div id="progress3" class="progress full progress-blue"><span><b></b></span></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="clear">&nbsp;</div>

        </section>
        <!-- End of Left column/section -->

        <!-- Right column/section -->
        <aside class="column width2">
            <div id="rightmenu">
                <header>
                    <h3>Your Account</h3>
                </header>
                <dl class="first">
                    <dt><img width="16" height="16" alt="" src="<?php echo Yii::app()->theme->baseUrl ?>/images/key.png"></dt>
                    <dd><a href="#"><?php echo Util::intersky_getUserRole();?> (<?php echo $userNm;?>)</a></dd>
                    <dd class="last"><?php echo Util::userFullNameByID(Yii::app()->user->id, false); ?></dd>

                    <dt><img width="16" height="16" alt="" src="<?php echo Yii::app()->theme->baseUrl ?>/images/help.png"></dt>
                    <dd><a href="#">Support</a></dd>
                    <dd class="last">logos010@gmail.com </dd>
                </dl>
            </div>
        </aside>
        <!-- End of Right column/section -->

    </div>
    <!-- End of Wrapper -->
</div>
<!-- End of Page content -->
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/js/administry.js"></script>
<script>
    $().ready(function(){
        var totalFloor = <?php echo Util::getTotalFloorInStorage(); ?>;
        var filledFloor = <?php echo Util::getFilledFloor(); ?>;
        var emptyFloor = <?php echo Util::getEmptyFloor(); ?>;
        var withdrew = <?php echo Util::getWiddrewDossier(); ?>;
        /* progress bar animations - setting initial values */
	Administry.progress("#progress1", emptyFloor, totalFloor);
	Administry.progress("#progress2", filledFloor, totalFloor);
        Administry.progress("#progress3", withdrew, totalFloor);
    });
</script>