<?php

class Controller extends CController {

    public $operations = array();

    public function filterAccessControl($filterChain) {
        $filter = new AccessControlFilter;
        $filter->setRules($this->accessRules());
        $filter->filter($filterChain);
    }

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/main';

    public function beforeAction($action) {
		if (!Util::intersky_checkRole()) {
			$this->redirect(Yii::app()->createUrl('user/logout'));
		}
		return true;
    }

}