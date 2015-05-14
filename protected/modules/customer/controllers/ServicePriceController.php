<?php

class ServicePriceController extends Controller
{
public function init(){
		Yii::app()->theme = ADMIN_THEME;
		parent::init();
	}
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
		$model=new ServicePrice;
		$model->cus_id = $id;
		// Uncomment the following line if AJAX validation is needed
		if(isset($_POST['ServicePrice']))
		{
			$model->attributes		= $_POST['ServicePrice'];
			$price					= $_POST['ServicePrice']['price'];
			$model->price 			= preg_replace('[\.|\,|\s]', '', $price);
			$model->status 	= 1;

			if($model->save())
				$this->redirect(array('/customer/contractprice/index','id'=>$_GET['id']));
			else
				$model->price 	= $price;
		}

		$this->render('create',array(
			'model'=>$model,
		));

	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['ServicePrice']))
		{
			$model->attributes	= $_POST['ServicePrice'];
			$price				= $_POST['ServicePrice']['price'];
			$model->price 		= preg_replace('[\.|\,|\s]', '', $price);
			if($model->save())
				$this->redirect(array('/customer/contractprice/index','id'=>$model->cus_id));
			else
				$model->price 	= $price;
		}
		else {
			$model->price 	= number_format($model->price, 0, 3, ' ');
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if($id != "")
		{
			// Delete all dependence of service
			ServicePrice::model()->updateAll(array("status" => "0"), "service_id = :id", array(":id" => $id));
			// Delete service price
			ServicePrice::model()->updateByPk($id, array("status" => 0));
			// Get cus_id
			$service = ServicePrice::model()->find("service_id = :id", array(":id" => $id));
			$this->redirect(array('/customer/contractprice/index','id' => $service->cus_id));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($id)
	{
		// Init object
		$criteria = new CDbCriteria();
		$criteria->select 		= "contract_id, contract_range, t.cus_id, price, create_time, note, contract_code";
		$criteria->join 		= "JOIN customer ON t.cus_id = customer.cus_id";
		$criteria->condition 	= "t.cus_id = :id AND t.contract_flag = 1";
		$criteria->params = array(
			':id' => $id
		);
		$criteria->order 	= "contract_range ASC";
		$objContracts = ServicePrice::model()->findAll($criteria);
		$this->render('index', compact('objContracts'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ServicePrice::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}