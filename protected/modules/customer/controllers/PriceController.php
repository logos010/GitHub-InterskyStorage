<?php

class PriceController extends Controller
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
	public function actionCreate()
	{
		$model=new Price;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Price']))
		{
			$model->attributes=$_POST['Price'];
			$model->status = 1;
			if($model->save())
				$this->redirect($this->createUrl('/customer/price/index'));
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Price']))
		{
			$model->attributes=$_POST['Price'];
			if($model->save())
				$this->redirect($this->createUrl('/customer/price/index'));
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
		if($id != ""){
			$model	= new Price;
			$model->updateByPk($id, array("status" => 0));
			$this->redirect($this->createUrl('/customer/price/index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		// Init object
		$criteria = new CDbCriteria();

		// Int variable
		$sortType = array(
			'0' => 'DESC',
			'1' => 'ASC'
		);
		// Get data post
		$post = array(
			'keySearch' => '',
			'sortName'	=> 'price_id',
			'sortValue'	=> '0',
			'sortImg'	=> array('sorting_desc', 'sorting_asc'),
		);
		if(isset($_POST['Price'])) {
			$post = array_merge($post, $_POST['Price']);
		}

		$criteria->select = "price_id, price_name, value, description";
		if (trim($post['keySearch']) != '') {
			$keySearch = $post['keySearch'];
			$criteria->addSearchCondition('price_name', $keySearch, true, 'OR');
			$criteria->addSearchCondition('value', $keySearch, true, 'OR');
			$criteria->addSearchCondition('description', $keySearch, true, 'OR');
		}
		$criteria->condition = "status = 1";
		$criteria->order = $post['sortName'] . ' ' . $sortType[$post['sortValue']];

		// Paggging
		$count	= Customer::model()->count($criteria);
    	$pages	= new CPagination($count);
    	$pages->pageSize	= 10;
    	$pages->applyLimit($criteria);

		$objPrices = Price::model()->findAll($criteria);
		$this->render('index', compact('objPrices', 'post', 'pages'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Price('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Price']))
			$model->attributes=$_GET['Price'];

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
		$model=Price::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='price-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
