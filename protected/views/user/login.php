<!-- Wrapper -->
            <div class="wrapper-login">
                <!-- Login form -->
                <section class="full">

                    <div class="box box-info" style="margin-top: 10px">Type USERNAME & PASSWORD to login <span style="color: darkred; font-weight: bold">INTERSKY SYSTEM</span></div>

                    <form action="" method="post" id="loginform">

                        <p>
                            <label for="username" class="required">Username:</label><br>
                            <?php echo Html::activeTextField($user,'username', array('class' => 'full', 'id' => 'username')) ?>
                        </p>

                        <p>
                            <label for="password" class="required">Password:</label><br>
                            <?php echo Html::activePasswordField($user,'password', array('class' => 'full', 'id' => 'password')) ?>
                        </p>

                        <p>
                            <?php echo Html::activeCheckBox($user,'rememberMe'); ?>
                            <label for="remember" class="choice">Remember me?</label>
                        </p>

                        <p>
                            <?php echo Html::submitButton('Login', array('class' => 'btn btn-green big')); ?>
                            &nbsp; <a onclick="$('#emailform').slideDown(); return false;" href="javascript: //;">Forgot password?</a> or <a href="#">Need help?</a>
                        </p>
                        <div class="clear">&nbsp;</div>

                    </form>

                    <form action="#" method="post" style="display:none" id="emailform">
                        <div class="box">
                            <p id="emailinput">
                                <label for="email">Email:</label><br>
                                <input type="text" name="email" value="" class="full" id="email">
                            </p>
                            <p>
                                <input type="submit" value="Send" class="btn">
                            </p>
                        </div>
                    </form>

                </section>
                <!-- End of login form -->

            </div>
            <!-- End of Wrapper -->