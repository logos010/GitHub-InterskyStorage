<?php

class DossierTrackController extends Controller
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
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if($id != "")
		{
			$model	= new DossierTrack;
			$contract = $model->findByPk($id);

			// Init object
			$criteria = new CDbCriteria();

			$criteria->select 		= "dossier_id, floor_id, contract_price.cus_id";
			$criteria->condition 	= "t.contract_id = :id";
			$criteria->params 		= array(':id' => $id);
			$aDossier = CustomerDossier::model()->findAll($criteria);
			if (!empty($aDossier)) {
				$listFloor 		= array();
				$listDossier 	= array();
				foreach ($aDossier as $dossier) {
					$listFloor[] 	= $dossier->floor_id;
					$listDossier[] 	= $dossier->dossier_id;

					// Write log for dossier
					$track = new DossierTrack;
					$track->dossier_id 		= $dossier->dossier_id;
					$track->create_time 	= time();
					$track->status 			= 3;
					$track->incharge_info	= Yii::app()->user->id;
					$track->cus_id			= $dossier->contract_price->cus_id;
					$track->insert();
				}
				// Change status floor
				if (!empty($listFloor)) {
					$strFloorId = "('" . implode('\',\'', $listFloor) . "')";
					Floor::model()->updateAll(array("status" => "0"), "floor_id IN " . $strFloorId);
				}
				// Remove distribute
				if (!empty($listDossier)) {
					$strDossierId = "('" . implode('\',\'', $listDossier) . "')";
					StorageDistribute::model()->deleteAll("dossier_id IN " . $strDossierId);
				}

				// Delete all dossier of contract
				CustomerDossier::model()->updateAll(array("status" => "0"), "contract_id = :id", array(":id" => $contract->contract_id));
			}

			$model->updateByPk($id, array("contract_flag" => 0));
			$this->redirect(array('index','id' => $contract->cus_id));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($id = null)
	{
		// Init object
		$criteria = new CDbCriteria();

		$criteria->select 		= "t.dossier_id, t.create_time, t.new_location, t.old_location, t.status,t.user_name";
		if ($id != "") {
			$criteria->join 	= "JOIN customer_dossier ON customer_dossier.cus_id = :id AND customer_dossier.dossier_id = t.dossier_id";
			$criteria->params 	= array(":id" => $id);
		}
		$arrTrack = DossierTrack::model()->findAll($criteria);

		 // Get company name
        $arrCustomer = Customer::model()->findByPk($id);
        $companyName = $arrCustomer->company_name;

		$this->render('index', compact('arrTrack', 'companyName'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=DossierTrack::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}