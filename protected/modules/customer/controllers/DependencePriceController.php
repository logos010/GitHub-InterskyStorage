<?php

class DependencePriceController extends Controller {

    public function init() {
        Yii::app()->theme = ADMIN_THEME;
        parent::init();
    }

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/main';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
	/**
	 * Lists all models.
	 */
	public function actionIndex($id)
	{
		// Init variable
		$listYear 	= array();
		$params		= array();
		$conditions	= "";
		for($i = 2010; $i <= 2020; $i++) {
			$listYear[$i] = $i;
		}
		$listMonth = array();
		for($i = 1; $i <= 12; $i++) {
			$month = ($i < 10) ? ('0'. $i) : $i;
			$listMonth[$month] = $month;
		}
		$post = array (
			'listYear' 	=> $listYear,
			'listMonth'	=> $listMonth,
			'year'		=> date('Y'),
			'month'		=> date('m')
		);
		// Get post
		if (isset($_POST['fiter_dependence'])) {
			$post = array_merge($post, $_POST);
		}
		// Set condition
		$conditions = " 1=1";
		$joins		= "JOIN service_price ON service_price.service_id = t.service_id AND service_price.cus_id = :id";
		$params[':id'] = $id;
		if ($post['year'] != '') {
			$conditions 	.= " AND FROM_UNIXTIME(create_time, '%Y') = :year";
			$params[':year'] =  $post['year'];
		}
		if ($post['month'] != '') {
			$conditions 	.= " AND FROM_UNIXTIME(create_time, '%m') = :month";
			$params[':month'] =  $post['month'];
		}
		$criteria 	= new CDbCriteria();
		$criteria->select 		= "t.service_id, create_time, dependence_id, t.price";
		$criteria->condition 	= $conditions;
		$criteria->join 		= $joins;
		$criteria->params 		= $params;
		$criteria->order 		= "t.service_id ASC";
		$objDependences = DependencePrice::model()->findAll($criteria);
		$objDependences = self::getArrayFromData($objDependences);

		 // Get company name
        $arrCustomer = Customer::model()->findByPk($id);
        $companyName = $arrCustomer->company_name;

		$this->render('index', compact('objDependences', 'post', 'companyName'));
	}

	/**
	 * return array from record of database
	 * @param $data : the record select from database
	 */
	protected function getArrayFromData($data = array())
	{
		$return = array();
		$temps	= array();
		foreach($data as $dependence)
		{
			$service = $dependence->service;
		    $temps[$service->service_name][] = array(
		    	'id'			=> $dependence->dependence_id,
		    	'create_time' 	=> $dependence->create_time,
		    	'price'			=> $dependence->price,
		    	'service_id'	=> $service->service_id,
		    );
		}
		foreach ($temps as $serviceNm => $value) {
			$return[] = array(
				'service_id' 	=> $value[0]['service_id'],
				'service_name' 	=> $serviceNm,
				'amount'		=> count($value),
				'price'			=> $value[0]['price'] *  count($value),
				'date'			=> $value,
			);
		}
		return $return;
	}

    /**
     * Add a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionAdd($id) {
        $model = new DependencePrice;

        // Get Service Price
		$criteria = new CDbCriteria();
		$criteria->select 		= "service_id, service_name, price, cus_id";
		$criteria->condition 	= "t.service_id = :id AND t.status = 1";
		$criteria->params = array(
			':id' => $id
		);
		$objServices = ServicePrice::model()->find($criteria);
        if (!empty($objServices)) {
                $model->name 		= $objServices->service_name;
                $model->price 		= $objServices->price;
                $model->cus_id 		= $objServices->cus_id;
                $model->service_id 	= $id;
                $model->create_time = time();
                $model->status 		= 1;
                $model->save();
                $this->redirect(array('/customer/contractprice/index', 'id' => $objServices->cus_id));
        }

    }
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
	public function actionCreate($id) {
        $model = new DependencePrice;
        if (isset($_POST['DependencePrice'])) {
        	// Get data from POST
        	$timeStamp =  self::convertToTime($_POST['DependencePrice']['create_time']);
            $model->attributes = $_POST['DependencePrice'];
            $model->create_time = $timeStamp;
			$model->status 		= 1;

            // Get Service Price
            if ($model->service_id != "") {
	            $criteria = new CDbCriteria();
				$criteria->select 		= "service_name, price";
				$criteria->condition 	= "t.service_id = :id AND t.status = 1";
				$criteria->params = array(
					':id' => $model->service_id,
				);
				$objServices = ServicePrice::model()->find($criteria);
				$model->name 		= $objServices->service_name;
				$model->price 		= $objServices->price;
            }

            // Save dependence
			if ($model->save()) {
				 $this->redirect(array('/customer/dependenceprice/index', 'id' => $id));
			}
			else {
				$model->create_time = $_POST['DependencePrice']['create_time'];
			}
        }

        // Set listbox range
        $listService = CHtml::listData(ServicePrice::model()->findAll("status = 1 AND cus_id = :id", array(":id" => $id)), 'service_id', 'service_name');

        // Get company name
        $customer = Customer::model()->findByPk($id);
        $this->render('create', compact('model', 'customer', 'listService'));
    }

     /**
     * convertToTime
     */
	public function convertToTime($date = null) {
		$time = null;
		if ($date != "") {
			list($day, $month, $year) = preg_split('/\//', $date);
			$time = mktime(0, 0, 0, $month, $day, $year);
		}
		return $time;
	}

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if ($id != "") {
        	$objDependence = $this->loadModel($id);
            DependencePrice::model()->deleteByPk($id);
            $this->redirect(array('/customer/dependenceprice/index', 'id' => $objDependence->service->cus_id));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = DependencePrice::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }


}
