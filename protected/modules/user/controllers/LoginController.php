<?php

class LoginController extends Controller
{
        public function init() {
            Yii::app()->theme = LOGIN_THEME;
            parent::init();
        }
	public $defaultAction = 'login';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
					$this->lastViset();
                                        $userID = Yii::app()->user->id;
                                        $role = Role::model()->find(array(
                                            'condition' => 'user_id = :uid',
                                            'params' => array(
                                                ':uid' => Yii::app()->user->id,
                                            )
                                        ));

                                        $session = new CHttpSession;
                                        $session->open();

                                        if ($role !== null){
                                            if ($role->role_name == 'Customer'){    //redirect to customer pages
                                                $session['adminView'] = false;
                                                $this->redirect(Yii::app()->createUrl('/customer/customerdossier/index', array('id' => Util::intersky_getCustomerID(Yii::app()->user->id))));
                                            }else{
//                                                if (Yii::app()->user->returnUrl=='/index.php')
//                                                    $this->redirect(Yii::app()->controller->module->returnUrl);
//                                                else
//                                                    $this->redirect(Yii::app()->user->returnUrl);
                                                $session['adminView'] = true;
                                                $this->redirect(Yii::app()->createUrl('site/'));
                                            }
                                        }


				}
			}
			// display the login form
			$this->render('/user/login',array('model'=>$model));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}

	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->update(array('lastvisit_at'));
	}

}