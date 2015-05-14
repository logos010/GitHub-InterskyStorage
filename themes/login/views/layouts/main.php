    <!-- Mirrored from themeforest.net/item/administry-admin-template/full_screen_preview/113435?ref=lvraa%26ref=lvraa%26clickthrough_id=90572375%26redirect_back=true by HTTrack Website Copier/3.x [XR&CO'2010], Sat, 03 Nov 2012 08:08:27 GMT -->
    <!-- Added by HTTrack -->
<!DOCTYPE html>
<html lang="en">
    <head>
    	<meta http-equiv="content-type" content="text/html;charset=utf-8"><!-- /Added by HTTrack -->
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
        <!-- Your Custom Stylesheet -->
        <link type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/custom.css" rel="stylesheet">
        <!--swfobject - needed only if you require <video> tag support for older browsers -->
        <script type="text/javascript" async="" src="http://www.google-analytics.com/ga.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/swfobject.js" type="text/javascript"></script>
        <!-- jQuery with plugins -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-1.4.2.min.js" type="text/javascript"></script>
        <!-- Could be loaded remotely from Google CDN : <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script> -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.ui.core.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.ui.widget.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.ui.tabs.min.js" type="text/javascript"></script>
        <!-- jQuery tooltips -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.tipTip.min.js" type="text/javascript"></script>
        <!-- Superfish navigation -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.superfish.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.supersubs.min.js" type="text/javascript"></script>
        <!-- jQuery form validation -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.validate_pack.js" type="text/javascript"></script>
        <!-- jQuery popup box -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.nyroModal.pack.js" type="text/javascript"></script>
        <!-- Internet Explorer Fixes -->
        <!--[if IE]>
        <link rel="stylesheet" type="text/css" media="all" href="css/ie.css"/>
        <script src="js/html5.js"></script>
        <![endif]-->
        <!--Upgrade MSIE5.5-7 to be compatible with MSIE8: http://ie7-js.googlecode.com/svn/version/2.1(beta3)/IE8.js -->
        <!--[if lt IE 8]>
        <script src="js/IE8.js"></script>
        <![endif]-->
        <script type="text/javascript">

            $(document).ready(function(){

                /* setup navigation, content boxes, etc... */
                Administry.setup();

                // validate signup form on keyup and submit
                var validator = $("#loginform").validate({
                    rules: {
                        username: "required",
                        password: "required"
                    },
                    messages: {
                        username: "Enter your username",
                        password: "Provide your password"
                    },
                    // the errorPlacement has to take the layout into account
                    errorPlacement: function(error, element) {
                        error.insertAfter(element.parent().find('label:first'));
                    },
                    // set new class to error-labels to indicate valid fields
                    success: function(label) {
                        // set &amp;nbsp; as text for IE
                        label.html("&amp;nbsp;").addClass("ok");
                    }
                });

            });
        </script>
    </head>
    <?php
    	$currController = Yii::app()->controller->action->id;
    	$activeMenu = array(
			"login" 	=> "",
			"contact" 	=> "",
		);
		$classActive 	= "current";
		$activeMenu[$currController] = $classActive;
    ?>
    <body>
        <!-- Header -->
        <header id="top">
            <div class="wrapper-login">
                <!-- Title/Logo - can use text instead of image -->
                <div id="title"><img alt="Administry" src="<?php echo Yii::app()->theme->baseUrl ?>/images/logo/LogoIntersky.png"></div>
                <!-- Main navigation -->
                <nav id="menu">
                    <ul class="sf-menu sf-js-enabled sf-shadow">
                        <li class="<?php echo $activeMenu['login']?>"><a href="<?php echo Yii::app()->createUrl('/user/login/'); ?>">Login</a></li>
                        <li class="<?php echo $activeMenu['contact']?>"><a href="<?php echo Yii::app()->createUrl('/site/contact/'); ?>"><?php echo Yii::t('vi', 'Contact'); ?></a></li>
                    </ul>
                </nav>
                <!-- End of Main navigation -->
            </div>
        </header>
        <!-- End of Header -->
        <!-- Page title -->
        <div id="pagetitle">
            <div class="wrapper-login"></div>
        </div>
        <!-- End of Page title -->

        <!-- Page content -->
        <div id="page">
           <?php
            echo $content;
           ?>
        </div>
        <!-- End of Page content -->

        <!-- Page footer -->
        <footer id="bottom">
            <div class="wrapper-login">
<!--                <p>Copyright &copy; 2010 <b><a href="http://themeforest.net/user/zoranjuric" target="_blank">Zoran Juric</a></b> | Icons by <a href="http://www.famfamfam.com/" target="_blank">FAMFAMFAM</a></p>-->
            </div>
        </footer>
        <!-- End of Page footer -->

        <!-- User interface javascript load -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/administry.js" type="text/javascript"></script>
        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-153700-8']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>

        <div style="max-width: 200px; display: none; margin: 446px 0px 0px 684px;" id="tiptip_holder" class="tip_bottom">
        	<div id="tiptip_arrow" style="margin-left: 90.5px; margin-top: -12px;"><div id="tiptip_arrow_inner"></div></div>
        	<div id="tiptip_content">Visit my profile page @ThemeForest</div>
        </div>
	</body>
</html>
