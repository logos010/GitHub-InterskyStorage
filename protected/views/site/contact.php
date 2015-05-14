<?php if(!Yii::app()->user->isGuest) : ?>
<div id="pagetitle">
    <div class="wrapper">
        <h1 class="title"><?php echo Yii::t('vi', 'Contact Information'); ?></h1>
    </div>
</div>
<?php endif;?>
<!-- Page content -->
<div id="page">
    <!-- Wrapper -->
    <div class="wrapper" <?php echo (Yii::app()->user->isGuest) ? 'style="width:375px"' : "";?> >
        <div id="breadcrumbs">
            <?php
             if (Util::intersky_getUserRole() != 'Customer' && !Yii::app()->user->isGuest) {
	            $this->widget('application.extensions.exbreadcrumbs.EXBreadcrumbs', array(
	                'links' => array(
	                    'Contact'
	                )
	            ));
             }
            ?>
        </div>

        <!-- Left column/section -->
        <section class="column width8 first">
            <div class="column width3 first">

                <div class="content-box corners">
                    <header>
                        <h3>storage.intersky.com.vn</h3>
                    </header>
                    <section>
                        <p>Business Support System</p>
                        <table class="no-style full">
                            <tbody>
                                <tr>
                                    <td><b>Contact</b></td>
                                    <td class="ta-left">TA CHIEU TUAN</td>
                                </tr>
                                <tr>
                                    <td><b>Phone Number</b></td>
                                    <td class="ta-left">(08)38 251 351 ext 22</td>
                                </tr>
                                <tr>
                                    <td><b>Email</b></td>
                                    <td class="ta-left"><a href="mailto:tuantc@intersky.com.vn">tuantc@intersky.com.vn</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                     <section>
                        <p>Technical Support System</p>
                        <table class="no-style full">
                            <tbody>
                                <tr>
                                    <td><b>Contact</b></td>
                                    <td class="ta-left">CHAU QUOC DIEU</td>
                                </tr>
                                <tr>
                                    <td><b>Phone Number</b></td>
                                    <td class="ta-left">0983.988.032</td>
                                </tr>
                                <tr>
                                    <td><b>Email</b></td>
                                    <td class="ta-left"><a href="mailto:logos010@gmail.com">logos010@gmail.com</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
        </section>
        <div class="clear">&nbsp;</div>
    </div>
    <!-- End of Wrapper -->
</div>
<!-- End of Page content -->