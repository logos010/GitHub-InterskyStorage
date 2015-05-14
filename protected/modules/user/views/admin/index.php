<div id="pagetitle">
    <div class="wrapper">
        <h1 class="title">User Managenemt</h1>
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
	                    'links'=> array(
	                        'User'
	                    )
	                ));
             }
            ?>
        </div>

        <!-- Left column/section -->
        <section class="column width8 first">
            <div class="clear"></div>
            <?php
                $this->renderPartial('listUserPage', array('users' => $model, 'profile' => $profile));
            ?>
        </section>
    </div>
    <!-- End of Wrapper -->
</div>
<!-- End of Page content -->
