<?php

class RangeController extends Controller {

    public function init() {
        Yii::app()->theme = ADMIN_THEME;
        parent::init();
    }

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
    public function actionCreate() {
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Range'])) {
            if (isset($_POST['num_of_building_ranges']) && $_POST['num_of_building_ranges'] >= 1) {
                for ($i = 1; $i <= $_POST['num_of_building_ranges']; $i++) {     //number of ranges could like to build
                    //insert a record into RANGE table
                    $model = new Range;
                    if ($i == 1)  //add range_name in default field
                        $model->range_name = $_POST['Range']['range_name'];
                    else    //set range_name in advances fields
                        $model->range_name = $_POST['rang']['name'][$i - 2];
                    $model->storage_id = 1;
                    $model->floor = 1;
                    $model->range_column = $_POST['Range']['range_column'];
                    $model->pressed_wall = $_POST['Range']['pressed_wall'];

                    if (!$model->save()) {
                        $model->addError('range_name', 'Range had already existed');
                        $this->render('create', array('model' => $model));
                    }

                    $rangeFloor = explode(',', RANGE_FLOOR);
                    $numSite = (!$model->pressed_wall) ? 2 : 1;
//                            if (!$model->pressed_wall){      //check the range pressed wall
                    // range does not pressed to the wall, create and insert 2 direction: LEFT & RIGHT
                    for ($direct = 1; $direct <= $numSite; $direct++) {
                        for ($rangesCol = 1; $rangesCol <= $model->range_column; $rangesCol++) {
                            for ($j = 1; $j <= $_POST['range_column_contain']; $j++) {   //create 4 floors in range's column
                                //insert record into CONTAIN table
                                $containModel = new Contain;
                                $containModel->range_id = $model->range_id;

                                if ($model->pressed_wall)
                                    $containModel->direction = $_POST['range_direction'];
                                else
                                    $containModel->direction = ($direct == 1) ? 'L' : 'R';

                                $containModel->column = $rangesCol;     //column contain belong to
                                $containModel->cell = $rangeFloor[$j - 1];
                                $containModel->save();

                                for ($col = 1; $col <= FLOOR_COLUMN; $col++) {
                                    for ($row = 1; $row <= FLOOR_ROW; $row++) {
                                        //insert record into FLOOR table
                                        if ($rangeFloor[$j - 1] == 'S' && $row >= 2)
                                            continue;

                                        $floorModel = new Floor;
                                        $floorModel->floor_name = $rangeFloor[$j - 1] . $col . "-" . $row;
                                        $floorModel->contain_id = $containModel->contain_id;
                                        $floorModel->sub_floor = $col . '-' . $row;
                                        $floorModel->location_code = $model->range_name . $containModel->direction . $rangesCol . $rangeFloor[$j - 1] . $col . $row;
                                        $floorModel->range_id = $model->range_id;
                                        $floorModel->status = 0;
                                        $floorModel->save();
                                    }
                                }
                            }   //end of range's column floor (N - E - S - W)
                        }
                    }
                }
            }
        }

        $model = new Range;
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($rid) {
        $model = $this->loadModel($rid);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Range'])) {
            $model->attributes = $_POST['Range'];
            if ($model->save())
                $this->redirect(array('/storage/range/index'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
//		$dataProvider=new CActiveDataProvider('Range');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
        $criteria = new CDbCriteria();

        $ranges = Range::model()->findAll($criteria);

        if (Yii::app()->request->isAjaxRequest) {
            $aaData = '{"aaData": [';
            foreach ($ranges as $key => $value) {
                $aaData .= '{
                            "range_id" : "' . $value->range_id . '",
                            "range_name" : "' . $value->range_name . '",
                            "range_column" : "' . $value->range_column . '",
                            "pressed_wall" : "' . $value->pressed_wall . '"
                        },';
            }
            $aaData = substr_replace($aaData, '', -1);
            $aaData .= ']}';
        }

        $this->render('index', compact('ranges'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Range('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Range']))
            $model->attributes = $_GET['Range'];

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
        $model = Range::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'range-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * View Contain in spectified range
     */
    public function actionViewContainInRange($rid) {
        $criteria = new CDbCriteria();
        $criteria->condition = 'range_id = :rid';
        $criteria->params = array(
            ':rid' => $rid,
        );

        $contains = Contain::model()->findAll($criteria);

        $rangeModel = Range::model()->find('range_id = :rangeID', array(':rangeID' => $rid));

        $this->render('viewContainInRange', compact('contains', 'rid', 'rangeModel'));
    }

    /**
     * View contain in general format
     */
    public function actionViewContainInSummary($rid) {
        $criteria = new CDbCriteria();
        $criteria->condition = 'range_id = :rid';
        $criteria->params = array(
            ':rid' => $rid,
        );
        $criteria->order = 't.column';

        $contains = Contain::model()->findAll($criteria);
        $this->render('viewContainInSummary', array(
            'contains' => $contains
        ));
    }

}
