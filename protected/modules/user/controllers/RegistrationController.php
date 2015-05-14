<?php

class RegistrationController extends Controller {

    public function init() {
        Yii::app()->theme = ADMIN_THEME;
        parent::init();
    }

    public $defaultAction = 'registration';

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }

    /**
     * Registration user
     */
    public function actionRegistration() {
        $model = new RegistrationForm;
        $profile = new Profile;
        $profile->regMode = true;

        // ajax validator
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form') {
            echo UActiveForm::validate(array($model, $profile));
            Yii::app()->end();
        }

//        if (Yii::app()->user->id) {
//            $this->redirect(Yii::app()->controller->module->profileUrl);
//        } else {
        if (isset($_POST['RegistrationForm'])) {
            $model->attributes = $_POST['RegistrationForm'];
            $profile->attributes = ((isset($_POST['Profile']) ? $_POST['Profile'] : array()));
            if ($model->validate() && $profile->validate()) {
                $soucePassword = $model->password;
                $model->activkey = UserModule::encrypting(microtime() . $model->password);
                $model->password = UserModule::encrypting($model->password);
                $model->verifyPassword = UserModule::encrypting($model->verifyPassword);
                $model->superuser = 0;
                $model->status = ((Yii::app()->controller->module->activeAfterRegister) ? User::STATUS_ACTIVE : User::STATUS_NOACTIVE);

                if (isset($_POST['RegistrationForm']['cus_id']))
                    $model->cus_id = $_POST['RegistrationForm']['cus_id'];

                if ($model->save()) {
                    $profile->user_id = $model->id;
                    $profile->save();

                    // insert record in role table
                    $sendPassword = $this->actionInsertRole($_POST['role'], $model->id);
                    if ($sendPassword){
                        $subject = "Login INTERSKY INFORMATION";
                        $message = "Dear, <br/> Please login to INTERSKY provided System followed to change your password: <br/><p>Account: '".$model->username."' <br/>Password: '".$_POST['RegistrationForm']['password']."'</br> Access link: ".Yii::app()->createUrl('/user/login');
                        UserModule::sendMailPassword($model->email, $subject, $message);
                    }


                    if (Yii::app()->controller->module->sendActivationMail) {
                        $activation_url = $this->createAbsoluteUrl('/user/activation/activation', array("activkey" => $model->activkey, "email" => $model->email));
                        UserModule::sendMail($model->email, UserModule::t("You registered from {site_name}", array('{site_name}' => Yii::app()->name)), UserModule::t("Please activate you account go to {activation_url}", array('{activation_url}' => $activation_url)));
                    }

//                    if ((Yii::app()->controller->module->loginNotActiv || (Yii::app()->controller->module->activeAfterRegister && Yii::app()->controller->module->sendActivationMail == false)) && Yii::app()->controller->module->autoLogin) {
//                        $identity = new UserIdentity($model->username, $soucePassword);
//                        $identity->authenticate();
//                        Yii::app()->user->login($identity, 0);
//                        $this->redirect(Yii::app()->controller->module->returnUrl);
//                    } else {
//                        if (!Yii::app()->controller->module->activeAfterRegister && !Yii::app()->controller->module->sendActivationMail) {
//                            Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
//                        } elseif (Yii::app()->controller->module->activeAfterRegister && Yii::app()->controller->module->sendActivationMail == false) {
//                            Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please {{login}}.", array('{{login}}' => CHtml::link(UserModule::t('Login'), Yii::app()->controller->module->loginUrl))));
//                        } elseif (Yii::app()->controller->module->loginNotActiv) {
//                            Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please check your email or login."));
//                        } else {
//                            Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please check your email."));
//                        }
//                        $this->refresh();
//                    }
					$this->redirect(Yii::app()->createUrl('/user/admin'));
                }
            } else
                $profile->validate();
        }
        $this->render('/user/registration', array('model' => $model, 'profile' => $profile));
//        }
    }

    public function actionInsertRole($roleID, $uid){
        $role = new Role();

        if ($roleID == 1){  //Admin
            $role->role_name = "Administrator";
        }else if ($roleID == 2){    //Staff
            $role->role_name = "Staff";
        }else if ($roleID == 3){    //Customer
            $role->role_name = "Customer";
        }

        $role->user_id = $uid;
        $role->create_time = time();
        if ($role->save())
            return true;
        else    return $role->getErrors();
    }

}