<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Util
 *
 * @author Lawrence
 */
class Util {

    public static function t($string, $params = array(), $category = 'Label') {
        Yii::import('application.modules.admin.models.Translate');

        $language = Yii::app()->language;
        $cache_id = sprintf('translations_%s_%s', $language, $category);

        $messages = false;
        if (Yii::app()->cache)
            $messages = Yii::app()->cache->get($cache_id);

        if ($messages === false) {
            $translations = Translate::model()->findAll('category = :category AND language_code = :language', array(
                ':category' => $category,
                ':language' => $language
                    ));
            $messages = array();
            foreach ($translations as $row) {
                $messages[$row->message] = $row->translation;
            }

            if (Yii::app()->cache)
                Yii::app()->cache->set($cache_id, $messages, Yii::app()->params['caching_time']);
        }

        if (isset($messages[$string]))
            return strtr($messages[$string], $params);
        else
            return strtr($string, $params);
    }

    public static function toAscii($str) {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        $str = ereg_replace("[-.,]", "", $str);
        $str = ereg_replace("[^ A-Za-z0-9]", " ", $str);
        return $str;
    }

    public static function toAlias($str) {
        $str = self::toAscii($str);
        $word_list = split(' ', $str);
        $str = '';
        foreach ($word_list as &$word) {
            if ($word != '')
                $str .= '-' . $word;
        }
        return trim(strtolower(substr($str, 1, strlen($str))));
    }

    public static function getFileExtension($filename) {
        return strtolower(substr($filename, strpos($filename, '.') + 1));
    }

    public static function generalNewID($lastID, $prefixChar) {
        if ($lastID != null) {
            $prefix = "";
            while (strlen($lastID) < 5) {
                $prefix .= 0;
                $lastID = $prefix . $lastID;
                $prefix = "";
            }

            return $prefixChar . $lastID;
        }
    }

    /**
     * check user role
     */
    public static function isAllowProcess($userID, $role, $controllerName, $controllerAction){
        if ($role == 'Administrator')
            return 1;
        else
            $role = UserRole::model()->findAll(array(
                'select' => 'controller_action',
                'condition' => 'user_id = :userID AND controller_name = :controllerName AND role = :role AND controller_action = :controllerAction AND status = 1',
                'params' => array(
                    ':userID' => $userID,
                    ':role' => $role,
                    ':controllerAction' => $controllerAction,
                    ':controllerName' => $controllerName
                )
            ));
        return $role;
    }

    public static function getUserRole($userID){
        Yii::import('application.modules.admin.models.AuthAssignment');
        $userRole = AuthAssignmentBase::model()->find(array(
            'condition' => 'userid = :userID',
            'params' => array(
                ':userID' => $userID
            ),
        ));

        if ($userRole)
            return $userRole->itemname;
        else
            return null;
    }

    /**
     * list all user except admin for create role access in UserRoleController
     */
    public static function listUsers(){
        $users = User::model()->findAll(array(
            'select' => 't.id, CONCAT(profile.lastname,\' \', profile.firstname) as fullname',
            'join' => 'JOIN profile ON profile.user_id = t.id JOIN auth_assignment ON auth_assignment.userid = t.id',
            'condition' => 'auth_assignment.itemname <> \'Administrator\''
        ));

        return CHtml::listData($users, 'id', 'fullname');
    }

    /**
     * list all role name
     */
    public static function listRolesName(){
        $role = User::model()->findAll(array(
            'select' => 'auth_assignment.itemname',
            'join' => 'JOIN auth_assignment ON  auth_assignment.userid = t.id',
            'condition' => 'auth_assignment.itemname <> \'Administrator\'',
        ));

        return CHtml::listData($role, 'itemname', 'itemname');
    }

    /**
     * Get User fullname by is
     */
    public static function userFullNameByID($id, $link=true){
        Yii::import('application.modules.user.models.Profile');
        $model = Profile::model()->findByPk($id);

        if($model === NULL)
            return Yii::t('vi', "Null Value");

        if ($link)
            return CHtml::link($model->last_name." ".$model->first_name, Yii::app()->createUrl('user/admin/view', array('id' => $model->user_id)), array('target' => '_blank'));
        else
            return $model->last_name." ".$model->first_name;
    }

    public static function lastLoginTime($id){
        $user = User::model()->findByPk(intval($id));

        if ($user !== null)
            return $user->lastvisit_at;
        else
            return null;
    }

    public static function getEmptyFloor($storageID = 1){
        $criteria = new CDbCriteria();
        $criteria->condition = "status = 0";

        $emptyFloor = Floor::model()->count($criteria);
        return $emptyFloor;
    }

    public static function getFilledFloor($storageID = 1){
        $criteria = new CDbCriteria();
        $criteria->condition = "status = 1";

        $filledFloor = Floor::model()->count($criteria);
        return $filledFloor;
    }

    public static function getTotalFloorInStorage($storageID = 1){
        $criteria = new CDbCriteria();

        $total = Floor::model()->count($criteria);
        return $total;
    }

    public static function getWiddrewDossier($storageID = 1){
        $criteria = new CDbCriteria();
        $criteria->condition = "status = 2";

        $withdrew = Floor::model()->count($criteria);
        return  $withdrew;
    }

    public static function getUserName(){
    	$aUserInfo = User::model()->findByPk(Yii::app()->user->id);
    	if ($aUserInfo !== null)
    	       return $aUserInfo->username;
        else   return 'Guest';
    }

    public static function isSupperUser(){
        $superUser = User::model()->find(array(
            'condition' => 'id = :userID',
            'params' => array(
                ':userID' => Yii::app()->user->id,
            )
        ));
        return $superUser->superuser ? true : false;
    }

    public static function intersky_getUserRole(){
    	$uid 	= Yii::app()->user->id;
        $role 	= Role::model()->find(array(
            'condition' => 'user_id = :uid',
            'params' => array(
                ':uid' => $uid
            )
        ));

        if ($role !== null)
            return $role->role_name;
        else
            return null;
    }

    public static function intersky_getExistedCustomerAccounts(){
        $acc = User::model()->findAll(array(
            'select' => 'cus_id',
            'condition' => 'cus_id != 0',
        ));

        if (count($acc)){
            $arrayAcc = array();
            foreach ($acc as $key => $value){
                array_push($arrayAcc, $value->cus_id);
            }
            return $arrayAcc;
        }
    }

    public static function intersky_getCustomerID($userID){
        $cusID = User::model()->find(array(
            'select' => 'cus_id',
            'condition' => 'id = :uid',
            'params' => array(
                ':uid' => $userID,
            )
        ));

        if ($cusID !== null){
            return $cusID->cus_id;
        }else return null;
    }

    /*create customer list for create customer login account*/
    public static function intersky_getCusttomerList($userRole = ""){
        $existedCustomers = self::intersky_getExistedCustomerAccounts();
        if ($existedCustomers !== null)
               $existedCus = implode(',', self::intersky_getExistedCustomerAccounts());
        else    $existedCus = 0;

        $criteria = new CDbCriteria();
        $criteria->condition = 'cus_id NOT IN ('.$existedCus.')';

        $customers = Customer::model()->findAll($criteria);
        if ($customers !== null){
            $customersBox = '<select name="RegistrationForm[cus_id]" '. (($userRole != 'Staff') ? 'disabled="disabled"' : '')  . ' id="customerListBox">';
            if (empty($customers)) {
            	 $customersBox .= '<option value="empty">Empty Customer</option>';
            }
            else {
	            foreach ($customers as $key => $value) {
	                $customersBox .= '<option value="'.$value->cus_id.'">'.$value->company_name.'</option>';
	            }
            }

            $customersBox .= '</select>';
        }
        return $customersBox;
    }

    public static function intersky_getAllCustomerId(){
    	$listCusId	= array();
    	$uId = User::model()->findAll(array(
            'select' 	=> 'user.id',
    		'join'		=> 'INNER JOIN Role ON Role.user_id = user.id and Role.role_name = :role',
            'params' 	=> array(':role' => 'Customer',)
        ));
        foreach ($uId as $value) {
        	$data = $value->attributes;
        	$listCusId[] = $data['id'];
        }
        return $listCusId;
    }

	public static function intersky_checkRole(){
		$denyRole = array(
			'Guest'		=> array(
				"module"		=> array("storage", "site", 'customer'),
				"controller"	=> array(),
				"action" 		=> array(
						"user" 	=> array(
							"registration" => array(),
							"admin" => array(),
						),
						""		=> array(
							"site"	=> array("index"),
						)
				),
			),
			'Customer' => array(
				"module"		=> array("storage", "site"),
				"controller"	=> array("contractprice", "serviceprice", "registration"),
				"action" 		=> array("customer" => array("customer" => array("index", "create", "update", "report"))),
			),
			'Staff' => array(
				"module"		=> array("storage"),
				"controller"	=> array("contractprice"),
				"action" 		=> array(),
			),
			'Administrator' => array(
				"module"		=> array(),
				"controller"	=> array(),
				"action" 		=> array(),
			),
		);

		$currUserId		= Yii::app()->user->id;
		$currModule 	= (isset(Yii::app()->controller->module)) ? Yii::app()->controller->module->id : "";
		$currController = Yii::app()->controller->id;
		$currAction		= Yii::app()->controller->action->id;
		$currUserRole	= self::intersky_getUserRole();
		$currUserRole	= ($currUserRole == "") ? "Guest" : $currUserRole;
		$denyRoleCurr 	= $denyRole[$currUserRole];

		//Check access module
		if (!in_array($currModule, $denyRoleCurr['module'])) {
			//Check access controller
			if (!in_array($currController, $denyRoleCurr['controller'])) {
				// Check edit user
				if ($currUserRole != 'Administrator' && $currModule == 'user' && $currController == 'admin' && $currAction == 'update' && ($_GET['id'] != $currUserId && $_GET['id'] != 'img')) {
					if ($currUserRole == 'Staff') {
						$listCusId = self::intersky_getAllCustomerId();
						if (in_array($_GET['id'], $listCusId)) {
							return true;
						}
					}
					return false;
				}
				//Check access action
				if (array_key_exists($currModule, $denyRoleCurr['action'])) {
					$checkAction = $denyRoleCurr['action'][$currModule];
					if (array_key_exists($currController, $checkAction) && (empty($checkAction[$currController]) || in_array($currAction,$checkAction[$currController]))) {
						return false;
					}
				}
				return true;
			}
		}

		return false;

    }
}

?>
