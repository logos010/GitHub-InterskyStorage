<?php

class CustomerDossierController extends Controller {

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
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id) {
        $model = new CustomerDossier;
        // Set contract_id
        $model->cus_id = $id;
        // Init variable
        $contains = array();
        $selectRange = '';
        $oldFloorId = "";

        if (isset($_POST['CustomerDossier'])) {
            $timeStampDes = self::convertToTime($_POST['CustomerDossier']['destruction_time']);
            $timeStampCre = self::convertToTime($_POST['CustomerDossier']['create_time']);
            $model->attributes = $_POST['CustomerDossier'];
            if (isset($_POST['yt0'])) {
                $model->destruction_time = $timeStampDes;
                $model->create_time = $timeStampCre;
                $model->update_time = null;
                $model->storage_id = 1;
                $model->status = 1;
                if ($model->save()) {
                    // Change status floor
                    Floor::model()->updateByPk($model->floor_id, array('status' => 1));
                    // Insert storage_distribute
                    $storage = new StorageDistribute;
                    $storage->storage_id = $model->storage_id;
                    $storage->dossier_id = $model->dossier_id;
                    $storage->floor_id = $model->floor_id;
                    $storage->cus_id = $model->cus_id;
                    $storage->insert();

                    // Write log
                    $aUserInfo = User::model()->findByPk(Yii::app()->user->id);
                    $track = new DossierTrack;
                    $track->dossier_id = $model->dossier_id;
                    $track->create_time = time();
                    $track->new_location = $model->floor->location_code;
                    $track->status = 1;
                    $track->user_name = $aUserInfo->username;
                    $track->insert();

                    $this->redirect(array('index', 'id' => $model->cus_id));
                } else {
                    $model->destruction_time = $_POST['CustomerDossier']['destruction_time'];
                    $model->create_time = $_POST['CustomerDossier']['create_time'];
                }
            } else if ($_POST['range'] != "") {
                $model->floor_id = 0;
                $model->validate();
                $model->floor_id = $_POST['CustomerDossier']['floor_id'];
                $criteria = new CDbCriteria();
                $criteria->condition = 'range_id = :rid';
                $criteria->params = array(
                    ':rid' => $_POST['range'],
                );
                $criteria->order = 't.column';

                $contains = Contain::model()->findAll($criteria);
                $selectRange = $_POST['range'];
            }
        } else {
            $model->create_time = date('d/m/Y');
        }

        // Set listbox range
        $listRange = CHtml::listData(Range::model()->findAll(), 'range_id', 'range_name');
        $range = array(
            'listRange' => $listRange,
            'selectRange' => $selectRange,
        );

        // Get floor name
        $model->floor_name = "";
        if ($model->floor_id != "") {
            $listFloor = Floor::model()->findByPk($model->floor_id);
            $model->floor_name = $listFloor->location_code;
        }
        $this->render('create', compact('model', 'range', 'contains', 'oldFloorId'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $currModel = $model->attributes;
        $oldFloorId = $model->floor_id;

        // Init variable
        $contains = array();
        $selectRange = '';
        if (isset($_POST['CustomerDossier'])) {
            $timeStampDes = self::convertToTime($_POST['CustomerDossier']['destruction_time']);
            $timeStampCre = self::convertToTime($_POST['CustomerDossier']['create_time']);
            $model->attributes = $_POST['CustomerDossier'];
            $model->destruction_time = $timeStampDes;
            $model->create_time = $timeStampCre;
            $model->note = $_POST['CustomerDossier']['note'];
            
            if (isset($_POST['yt0'])) {
                $model->update_time = time();
                $model->storage_id = 1;
                $model->status = 1;
                if ($model->save()) {
                    $statusFloor = (isset($_POST['withdrew_dossier']) && $_POST['withdrew_dossier'] == '1') ? 2 : 1;
                    // Write logs and update floor
                    self::logsAndUpdateFloor($currModel, $model, $oldFloorId, $statusFloor);
                                        
                    $this->redirect(array('index', 'id' => $model->cus_id));
                } else {
                    $model->destruction_time = $_POST['CustomerDossier']['destruction_time'];
                    $model->create_time = $_POST['CustomerDossier']['create_time'];
                }
            } else if ($_POST['range'] != "") {
                $model->floor_id = 0;
                $model->validate();
                $model->floor_id = $_POST['CustomerDossier']['floor_id'];

                $criteria = new CDbCriteria();
                $criteria->condition = 'range_id = :rid';
                $criteria->params = array(
                    ':rid' => $_POST['range'],
                );
                $criteria->order = 't.column';

                $contains = Contain::model()->findAll($criteria);
                $selectRange = $_POST['range'];
            }
        } else {
            $model->create_time = date('d/m/Y', $model->create_time);
        }

        $model->destruction_time = (is_numeric($model->destruction_time)) ? date('d/m/Y', $model->destruction_time) : $model->destruction_time;
        $model->create_time = (is_numeric($model->create_time)) ? date('d/m/Y', $model->create_time) : $model->create_time;

        // Set listbox range
        $listRange = CHtml::listData(Range::model()->findAll(), 'range_id', 'range_name');
        $range = array(
            'listRange' => $listRange,
            'selectRange' => $selectRange,
        );

        // Get floor name
        $model->floor_name = "";
        $floorStatus = 1;
        if ($model->floor_id != "") {
            $listFloor = Floor::model()->findByPk($model->floor_id);
            $floorStatus = $listFloor->status;
            $model->floor_name = $listFloor->location_code;
        }
        $model->withdrew_dossier = ((isset($_POST['withdrew_dossier']) && $_POST['withdrew_dossier'] == '1') || $floorStatus == '2') ? true : false;
        $this->render('update', compact('model', 'range', 'contains', 'oldFloorId'));
    }

    /**
     * logsUpdate
     */
    protected function logsAndUpdateFloor($currData, $update, $oldFloorId, $statusFloor) {
        $editData = $update->attributes;
        // Set data log
        $logs = array(
            'time' => time(),
            'dossier_id' => $update->dossier_id,
            'status' => 2,
            'new_location' => $update->floor->location_code,
        );

        $aOldFloor = Floor::model()->findByPk($oldFloorId);
        $changeLocation = ($oldFloorId != $update->floor_id) ? true : false;

        // Write log update
        $checkUpdate = array_diff($currData, $editData);
        if (!empty($checkUpdate) && !(count($checkUpdate) == 1 && array_key_exists('update_time', $checkUpdate)) || $changeLocation) {
            // Reset status floor
            if ($changeLocation) {
                Floor::model()->updateByPk($oldFloorId, array('status' => 0));
                $logs['old_location'] = $aOldFloor->location_code;
            }
            self::writeLogs($logs);
        }
        if (array_key_exists('old_location', $logs)) {
            unset($logs['old_location']);
        }
        // Write log withdraw
        if ($statusFloor == '2') {
            $logs['status'] = 5;
            self::writeLogs($logs);
        }
        // Write log deposit
        elseif ($aOldFloor->status == '2' && $statusFloor == '1') {
            $logs['status'] = 6;
            self::writeLogs($logs);
        }

        // Change status floor
        Floor::model()->updateByPk($update->floor_id, array('status' => $statusFloor));

        // Insert storage_distribute
        StorageDistribute::model()->updateByPk($update->dossier_id, array("storage_id" => $update->storage_id, "floor_id" => $update->floor_id, "cus_id" => $update->cus_id));
    }

    protected function writeLogs($logs) {
        // Set data log
        $aUserInfo = User::model()->findByPk(Yii::app()->user->id);
        $track = new DossierTrack;
        $track->create_time = $logs['time'];
        $track->dossier_id = $logs['dossier_id'];
        $track->user_name = $aUserInfo->username;
        $track->status = $logs['status'];
        $track->new_location = $logs['new_location'];
        if (array_key_exists('old_location', $logs)) {
            $track->old_location = $logs['old_location'];
        }
        $track->insert();
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if ($id != "") {
            $model = new CustomerDossier;

            $dossier = $model->findByPk($id);
            // Update status for delete
            $model->updateByPk($id, array("status" => 0));
            // Change status floor
            Floor::model()->updateByPk($dossier->floor_id, array('status' => 0));
            // Remove distribute
            StorageDistribute::model()->deleteByPk($id);
            // Write log
            $track = new DossierTrack;
            $aUserInfo = User::model()->findByPk(Yii::app()->user->id);
            $track->dossier_id = $dossier->dossier_id;
            $track->create_time = time();
            $track->status = 3;
            $track->new_location = $dossier->floor->location_code;
            $track->user_name = $aUserInfo->username;
            $track->insert();

            $this->redirect(array('index', 'id' => $dossier->cus_id));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex($id) {
        // Init object
        $criteria = new CDbCriteria();

        // Set customer_id
        $objDossiers = new CustomerDossier();
        $criteria->select = "dossier_id, t.cus_id, dossier_name, dossier_no, seal_no, destruction_time, create_time, update_time, t.note, t.floor_id";
        $criteria->join = "JOIN floor ON floor.floor_id = t.floor_id";
        $criteria->condition = "t.cus_id = :id AND t.status = 1";
        $criteria->params = array(
            ':id' => $id
        );
        $arrDossiers = $objDossiers->findAll($criteria);

        // Get company name
        $arrCustomer = Customer::model()->findByPk($id);
        $companyName = $arrCustomer->company_name;

        $this->render('index', compact('arrDossiers', 'companyName'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CustomerDossier('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CustomerDossier']))
            $model->attributes = $_GET['CustomerDossier'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = CustomerDossier::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dossier-price-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * return array from record of database
     * @param $data : the record select from database
     */
    protected function getArrayFromData($data = array()) {
        $return = array();
        foreach ($data as $value) {
            $return[$value->dossier_id] = $value->attributes;
        }
        return $return;
    }

    /**
     * Author Lawrence
     * Export excel for customer dossier */
    public function actionExportCustomerDossier($cid) {
        /*
         * Load data
         */
        $criteria = new CDbCriteria();
        //$criteria->select = "dossier_id, t.cus_id, dossier_name, dossier_no, seal_no, create_time, t.note, t.floor_id";
        $criteria->condition = "t.cus_id = :id AND t.status = 1";
        $criteria->params = array(':id' => $cid);
        $customer = Customer::model()->find($criteria);

        $criteria = new CDbCriteria();
        //$criteria->select = "dossier_id, t.cus_id, dossier_name, dossier_no, seal_no, create_time, t.note, t.floor_id";
        $criteria->condition = "t.cus_id = :id AND t.status = 1";
        $criteria->params = array(':id' => $cid);
        $dossiers = CustomerDossier::model()->findAll($criteria);

        /*
         * Create excel
         */
        Yii::import('application.extensions.excel.PHPExcel');
        Yii::import('application.extensions.excel.PHPExcel.IOFactory');

        $objPHPExcel = new PHPExcel();
        $objReader = new PHPExcel_Reader_Excel5;

        //Load template
        $path = Yii::app()->theme->basePath . '/template/view_box.xls';
        $objPHPExcel = $objReader->load($path);


        //Fill customer information
        $cusName = $customer->company_name;
        $objPHPExcel->getActiveSheet()->SetCellValue('B3', $customer->contract_code);
        $objPHPExcel->getActiveSheet()->SetCellValue('B4', $cusName);
        $objPHPExcel->getActiveSheet()->SetCellValue('B5', $customer->comp_phone);
        $objPHPExcel->getActiveSheet()->SetCellValue('B6', $customer->comp_fax);
        $objPHPExcel->getActiveSheet()->SetCellValue('B7', $customer->comp_email);
        $objPHPExcel->getActiveSheet()->SetCellValue('B8', $customer->comp_address);

        //Fill box information
        $i = 11;
        foreach ($dossiers as $value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $value->dossier_no);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $value->seal_no);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $value->dossier_name);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $value->floor->location_code);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, date('d-m-Y', $value->create_time));
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, date('d-m-Y', $value->destruction_time));
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $value->note);
            $i++;
        }

        // Fix Template
        $objPHPExcel->getActiveSheet()->removeRow($i, 1000 - count($dossiers));

        if (!Util::isSupperUser()) {     //if user is not SupperUser, export readonly excel file
            //secure in excel
            $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
            $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
            $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
            $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
        }


        // Save Excel 2005 file
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $fileName = preg_replace('[\s]', '_', $cusName) . "_" . date('dmYhis', time()) . ".xls";
        $objWriter->save(Yii::getPathOfAlias('webroot') . "/uploads/" . $fileName);

        if (file_exists(Yii::getPathOfAlias('webroot') . "/uploads/" . $fileName))
            return $fileName;
        else
            return null;
    }

    /**
     * Author Lawrence
     * Download dossier file of customer - Excel 2007
     */
    public function actionDownloadCustomerDossierExcel($id) {
        $fileName = $this->actionExportCustomerDossier($id);

        //check file exist for download
        if ($fileName !== null) {
            header('Content-Disposition: attachment; filename=' . $fileName);
            header('Content-Type: application/force-download');
            header('Content-Type: application/octet-stream');
            header('Content-Type: application/download');
            header('Content-Description: File Transfer');
            header('Content-Length: ' . filesize(Yii::getPathOfAlias('webroot') . "/uploads/" . $fileName));
            echo file_get_contents(Yii::getPathOfAlias('webroot') . "/uploads/" . $fileName);
        }else
            echo "File Download Not Found";
    }

    public function convertToTime($date = null) {
        $time = null;
        if ($date != "") {
            list($day, $month, $year) = split('/', $date);
            $time = mktime(0, 0, 0, $month, $day, $year);
        }
        return $time;
    }

}
