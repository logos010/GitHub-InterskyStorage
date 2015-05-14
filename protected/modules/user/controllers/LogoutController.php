<?php

class LogoutController extends Controller
{
	public $defaultAction = 'logout';
	
	/**
	 * Logout the current user and redirect to returnLogoutUrl.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
                $session = new CHttpSession();
                $session['adminView'] = FALSE;
                $session->close();
		$this->redirect(Yii::app()->controller->module->returnLogoutUrl);
	}

}