<?php

class ContractPriceController extends Controller
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
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
		$model=new ContractPrice;
		$model->cus_id = $id;
		// Get greatest value range of avail contract
		$criteria = new CDbCriteria();
		$criteria->select 		= "max(SUBSTRING_INDEX(contract_range, '-', -1)) as contract_range";
		$criteria->condition 	= "t.cus_id = :id AND t.contract_flag = 1";
		$criteria->params = array(
			':id' => $id
		);
		$objContracts = $model->find($criteria);
		if(isset($_POST['ContractPrice']))
		{
			$model->contract_range_fr 	= $_POST['ContractPrice']['contract_range_fr'];
			$model->contract_range_to 	= $_POST['ContractPrice']['contract_range_to'];
			$price						= $_POST['ContractPrice']['price'];

			$model->attributes		= $_POST['ContractPrice'];
			$model->contract_range	= $model->contract_range_fr . ' - ' . $model->contract_range_to;
			$model->create_time 	= time();
			$model->price 			= preg_replace('[\.|\,|\s]', '', $price);
			$model->contract_flag 	= 1;

			if($model->save())
				$this->redirect(array('index','id'=>$model->cus_id));
			else
				$model->price = $price;
		}

		// Rebuil error
		$model = self::rebuildError($model);

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
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ContractPrice']))
		{
			$model->contract_range_fr 	= $_POST['ContractPrice']['contract_range_fr'];
			$model->contract_range_to 	= $_POST['ContractPrice']['contract_range_to'];
			$price						= $_POST['ContractPrice']['price'];
			$model->attributes			= $_POST['ContractPrice'];
			$model->contract_range		= $model->contract_range_fr . ' - ' . $model->contract_range_to;
			$model->price 				= preg_replace('[\.|\,|\s]', '', $price);

			if($model->save())
				$this->redirect(array('index','id'=>$model->cus_id));
			else
				$model->price = $price;
		}
		else {
			$contract_range 			= explode('-', $model->contract_range);
			$model->contract_range_fr 	= $contract_range[0];
			$model->contract_range_to 	= $contract_range[1];
			$model->price 				= number_format($model->price, 0, '', ' ');
		}

		// Rebuil error
		$model = self::rebuildError($model);

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
			$model	= new ContractPrice;
			$model->updateByPk($id, array("contract_flag" => 0));
			$this->redirect(array('index','id' => $contract->cus_id));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($id)
	{
		// Get Customer Info
		$criteria = new CDbCriteria();
		$criteria->select 		= "company_name, contract_code";
		$criteria->condition 	= "t.cus_id = :id";
		$criteria->params = array(
			':id' => $id
		);
		$objCustomes = Customer::model()->find($criteria);

		// Get Contract Price
		$criteria = new CDbCriteria();
		$criteria->select 		= "contract_id, contract_range, t.cus_id, price, create_time, note, contract_code";
		$criteria->join 		= "JOIN customer ON t.cus_id = customer.cus_id";
		$criteria->condition 	= "t.cus_id = :id AND t.contract_flag = 1";
		$criteria->params = array(
			':id' => $id
		);
		$criteria->order 	= "contract_range ASC";
		$objContracts = ContractPrice::model()->findAll($criteria);

		// Get Service Price
		$criteria = new CDbCriteria();
		$criteria->select 		= "service_id, service_name, price, note, cus_id,
								(select count(dependence_id) from dependence_price where dependence_price.service_id = t.service_id and dependence_price.status = 1) as count_used";
		$criteria->condition 	= "t.cus_id = :id AND t.status = 1";
		$criteria->params = array(
			':id' => $id
		);
		$criteria->order 	= "service_id ASC";
		$objServices = ServicePrice::model()->findAll($criteria);

		$this->render('index', compact('objCustomes','objContracts', 'objServices', 'post'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ContractPrice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ContractPrice']))
			$model->attributes=$_GET['ContractPrice'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ContractPrice::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='contract-price-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
	 * rebuildError
	 * @param $model
	 */
	public function rebuildError ($model) {
		if (!empty($model->errors)) {
			$strError = "";
			$errRange = false;
			foreach ($model->errors as $attr => $error) {
				$strPoint = ($strError != "") ? "###" : "";
				if ($attr == 'contract_range_fr') {
					$strError .= $strPoint . $error[0];
				}
				if ($attr == 'contract_range_to') {
					$strError .= $strPoint . $error[0];
				}
				if ($attr == 'contract_range') {
					$errRange = true;
				}
			}
			if ($errRange) {
				$model->addError('contract_range_fr', "");
				$model->addError('contract_range_to', "");
			}
			$model->addError('contract_range', $strError);
		}
		return $model;
	}
}
