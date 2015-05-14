<!-- Mirrored from themeforest.net/item/administry-admin-template/full_screen_preview/113435?ref=lvraa%26ref=lvraa%26clickthrough_id=90572375%26redirect_back=true by HTTrack Website Copier/3.x [XR&CO'2010], Sat, 03 Nov 2012 08:08:27 GMT -->
<!-- Added by HTTrack --><!-- /Added by HTTrack -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" rel="stylesheet">
	<link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl ?>/images/logo/favicon.png" />
    <!-- Colour Schemes
    Default colour scheme is blue. Uncomment prefered stylesheet to use it.
    <link rel="stylesheet" href="css/brown.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/gray.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/green.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/pink.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/red.css" type="text/css" media="screen" />
    -->

    <!--swfobject - needed only if you require <video> tag support for older browsers -->
<!--    <script type="text/javascript" async="" src="http://www.google-analytics.com/ga.js"></script>-->
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/swfobject.js" type="text/javascript"></script>
    <!-- jQuery with plugins -->
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-1.4.2.min.js" type="text/javascript"></script>
    <!-- Could be loaded remotely from Google CDN : <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script> -->
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.ui.core.min.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.ui.widget.min.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.ui.tabs.min.js" type="text/javascript"></script>
    <!-- jQuery tooltips -->
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.tipTip.min.js" type="text/javascript"></script>

    <!-- jQuery form validation -->
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.validate_pack.js" type="text/javascript"></script>
    <!-- Internet Explorer Fixes -->
    <!--[if IE]>
    <link rel="stylesheet" type="text/css" media="all" href="css/ie.css"/>
    <script src="js/html5.js"></script>
    <![endif]-->
    <!--Upgrade MSIE5.5-7 to be compatible with MSIE8: http://ie7-js.googlecode.com/svn/version/2.1(beta3)/IE8.js -->
    <!--[if lt IE 8]>
    <script src="js/IE8.js"></script>
    <![endif]-->
    <!-- Admin template javascript load -->
</head>
<?php
	$activeMenu = array(
		"dashboard" 				=> "",
		"storage" 					=> "",
		"customer" 					=> "",
		"price" 					=> "",
		"statictics"				=> "",
		"user" 						=> "",
		"contact" 					=> "",
		"dependenceprice" 			=> "",
		"customerDossierStatistic" 	=> "",
		"customerdossier" 			=> "",
	);
	$classActive 	= "current";
	$currUserRole	= Util::intersky_getUserRole();
	$currController = Yii::app()->controller->id;
	$currAction		= Yii::app()->controller->action->id;

	if ($currController != 'site') {
		$currModule = Yii::app()->controller->module->id;
		if ($currController == 'price') {
			$activeMenu['price'] = $classActive;
		}
		else {
                    if ($currUserRole == 'Customer'){
                        if ($currController == 'dependenceprice'){
                            $activeMenu['dependenceprice'] = $classActive;
                        }
                        else if ($currAction == 'customerDossierStatistic'){
                            $activeMenu['customerDossierStatistic'] = $classActive;
                        }
                        else if ($currController == 'customerdossier'){
                            $activeMenu['customerdossier'] = $classActive;
                        }
                        else if ($currAction == 'admin') {
							$activeMenu['user'] = $classActive;
                        }

                        $activeMenu['customer'] = null;
                    }
                    else
						$activeMenu[$currModule] = $classActive;
		}
	}
	else {
		if ($currAction == 'contact') {
			$activeMenu['contact'] = $classActive;
		}
		else {
			$activeMenu["dashboard"] = $classActive;
		}
	}
?>
<body>
    <!-- Header -->
    <header id="top">
        <div class="wrapper">
            <!-- Title/Logo - can use text instead of image -->
            <div id="title"><img src="<?php echo Yii::app()->theme->baseUrl ?>/images/logo/LogoIntersky.png" alt="" /><!--<span>Administry</span> demo--></div>
            <!-- Top navigation -->
            <div style="width: 265px;" id="topnav">                
                Logged in as <b><?php echo Util::getUserName(); ?></b>
                <span>|</span> <a href="<?php echo Yii::app()->createUrl('/user/logout'); ?>">Logout</a><br />
                <small>Welcome to <a href="#" class="high">Intersky Storage System!</a></small>
            </div>
            <!-- End of Top navigation -->
            <!-- Main navigation -->
            <nav id="menu">
                <ul class="sf-menu">
                    <!-- Customer menu -->
                    <?php if ($currUserRole == 'Customer' ): ?>
                    	<?php $cusId = Util::intersky_getCustomerID(Yii::app()->user->id);?>
	                    <li class="<?php echo $activeMenu['customerdossier']?>">
	                        <a href="<?php echo Yii::app()->createUrl('/customer/customerdossier/index/', array('id' => $cusId)); ?>"><?php echo Yii::t('vi', 'Box'); ?></a>
	                    </li>
	                    <li class="<?php echo $activeMenu['dependenceprice']?>">
	                        <a href="<?php echo Yii::app()->createUrl('/customer/dependenceprice/index', array('id' => $cusId)); ?>"><?php echo Yii::t('vi', 'Services'); ?></a>
	                    </li>
	                    <li class="<?php echo $activeMenu['customerDossierStatistic']?>">
	                        <a href="<?php echo Yii::app()->createUrl('/customer/customer/customerDossierStatistic/', array('id' => $cusId)); ?>"><?php echo Yii::t('vi', 'Statistic'); ?></a>
	                    </li>
	                    <!-- End custoomer menu -->
                    <?php else : ?>
                    	<li class="<?php echo $activeMenu['dashboard']?>"><a href='<?php echo $activeMenu['dashboard']=='current' ? 'javascript:void(0)' : Yii::app()->createUrl('site/') ?>'><?php echo Yii::t('vi', 'Dashboard'); ?></a></li>
                    	<?php if ($currUserRole == 'Administrator') :?>
		                     <li class="<?php echo $activeMenu['storage']?>">
		                        <a href="<?php echo Yii::app()->createUrl('/storage/storage/index'); ?>"><?php echo Yii::t('vi', 'Storage'); ?></a>
		                        <ul>
		                            <li>
		                                <a href="<?php echo Yii::app()->createUrl('/storage/range/index'); ?>"><?php echo Yii::t('vi', 'Range'); ?></a>
		                            </li>
		                        </ul>
		                    </li>
	                    <?php endif;?>
	                    <li class="<?php echo $activeMenu['customer']?>">
	                        <a href="<?php echo Yii::app()->createUrl('/customer/customer/index'); ?>"><?php echo Yii::t('vi', 'Customer'); ?></a>
	                    </li>
                    <?php endif; ?>
                    <li class="<?php echo $activeMenu['user']?>"><a href="<?php echo Yii::app()->createUrl('user/admin') ?>"><?php echo Yii::t('vi', 'Users'); ?></a></li>
                    <li class="<?php echo $activeMenu['contact']?>"><a href="<?php echo Yii::app()->createUrl('/site/contact/'); ?>"><?php echo Yii::t('vi', 'Contact'); ?></a></li>
                </ul>
            </nav>
            <!-- End of Main navigation -->
            <!-- Aside links -->            
            <!-- End of Aside links -->
        </div>
    </header>
    <!-- End of Header -->

    <!-- Page Content -->
	<?php echo $content; ?>

    <!-- End of Page content -->

    <!-- Page footer -->
    <footer id="bottom">
        <div class="wrapper">
            <?php if ($currUserRole != 'Customer' ): ?>
            <nav>
                <a href="<?php echo Yii::app()->createUrl('/') ?>">Dashboard</a> &middot;
                <a href="<?php echo Yii::app()->createUrl('/storage/range/') ?>">Storage-Range</a> &middot;
                <a href="<?php echo Yii::app()->createUrl('/customer/customer/') ?>">Customer</a> &middot;
                <a href="<?php echo Yii::app()->createUrl('/user/admin') ?>">Users</a> &middot;
                <a href="<?php echo Yii::app()->createUrl('/site/contact/') ?>">Contact</a> &middot;
            </nav>
            <?php endif; ?>
            <p>Copyright &copy; 2012 <b>
                    <a href="http://themeforest.net/user/zoranjuric" title="Visit my profile page @ThemeForest">Zoran Juric</a>
                    </b> | Icons by <a href="http://www.famfamfam.com/">FAMFAMFAM</a>
                    <br/>
                    Developed by: ........  |
                    Supported by: <a href="http://www.yiiframework.com" title="Yii FW">Yii Framework</a></p>
        </div>
    </footer>
    <!-- End of Page footer -->

    <!-- Animated footer -->
<!--    <footer id="animated">-->
<!--        <ul>-->
<!--            <li><a href="<?php echo Yii::app()->createUrl('/') ?>">Dashboard</a></li>-->
<!--            <li><a href="<?php echo Yii::app()->createUrl('/storage/range/') ?>">Storage-Range</a></li>-->
<!--            <li><a href="<?php echo Yii::app()->createUrl('/customer/customer/') ?>">Customer</a></li>-->
<!--            <li><a href="<?php echo Yii::app()->createUrl('/user/admin') ?>">Users</a></li>-->
<!--            <li><a href="<?php echo Yii::app()->createUrl('/site/contact/') ?>">Contact</a></li>-->
<!--        </ul>-->
<!--    </footer>-->
    <!-- End of Animated footer -->

    <!-- Scroll to top link -->
    <a href="#" id="totop">^ scroll to top</a>
    <style type="text/css" title="currentStyle">
        @import "<?php echo Yii::app()->theme->baseUrl ?>/css/demo_table.css";
/*        @import "<?php echo Yii::app()->theme->baseUrl ?>/css/demo_page.css";*/
    </style>
    <!-- Your Custom Stylesheet -->
    <link type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/custom.css" rel="stylesheet">
    <!-- Superfish navigation -->
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.superfish.min.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.supersubs.min.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/administry.js" type="text/javascript"></script>
    <script type="text/javascript">
        $().ready(function(){
            Administry.setup();
        });
    </script>
</body>
</html>
