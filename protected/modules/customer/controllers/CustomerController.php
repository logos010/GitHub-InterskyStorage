<?php

class CustomerController extends Controller {

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
    public function actionCreate() {
        $model = new Customer;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Customer'])) {
            $model->attributes = $_POST['Customer'];
            $comp_phone = $_POST['Customer']['comp_phone'];
            $comp_fax = $_POST['Customer']['comp_fax'];
            $model->contract_time = self::convertToTime($_POST['Customer']['contract_time']);
            $model->comp_phone = preg_replace('[\.|\,|\s|\-]', '', $comp_phone);
            $model->comp_fax = preg_replace('[\.|\,|\s|\-]', '', $comp_fax);
            $model->status = 1;
            if ($model->save()) {
                $this->redirect($this->createUrl('/customer/customer/index'));
            } else {
                $model->comp_phone = $comp_phone;
                $model->comp_fax = $comp_fax;
                $model->contract_time = $_POST['Customer']['contract_time'];
            }
        } else {
            $model->contract_time = date('d/m/Y');
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function convertToTime($date = null) {
        $time = null;
        if ($date != "") {
            list($day, $month, $year) = split('/', $date);
            $time = mktime(0, 0, 0, $month, $day, $year);
        }
        return $time;
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['Customer'])) {
            $model->attributes = $_POST['Customer'];
            $comp_phone = $_POST['Customer']['comp_phone'];
            $comp_fax = $_POST['Customer']['comp_fax'];
            $model->contract_time = self::convertToTime($_POST['Customer']['contract_time']);
            $model->comp_phone = preg_replace('[\.|\,|\s|\-]', '', $comp_phone);
            $model->comp_fax = preg_replace('[\.|\,|\s|\-]', '', $comp_fax);

            if ($model->save()) {
                $this->redirect($this->createUrl('/customer/customer/index'));
            } else {
                $model->comp_phone = $comp_phone;
                $model->comp_fax = $comp_fax;
                $model->contract_time = $_POST['Customer']['contract_time'];
            }
        } else {
            $model->comp_phone = number_format($model->comp_phone, 0, 3, '.');
            $model->comp_fax = number_format($model->comp_fax, 0, 3, '-');
            $model->contract_time = date('d/m/Y', $model->contract_time);
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
        // Init object
        $criteria = new CDbCriteria();

        $criteria->select = "*, (select count(contract_id) from contract_price where contract_price.cus_id = t.cus_id and contract_flag = 1) as count_contract,
							(select count(service_id) from service_price where service_price.cus_id = t.cus_id and service_price.status = 1) as count_service,
							(select count(dossier_id) from customer_dossier where customer_dossier.cus_id = t.cus_id and customer_dossier.status = 1) as count_box";
        $objCustomers = Customer::model()->findAll($criteria);
        $this->render('index', compact('objCustomers'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Customer('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Customer']))
            $model->attributes = $_GET['Customer'];

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
        $model = Customer::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'customer-form') {
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
            $return[$value->cus_id] = $value->attributes;
        }
        return $return;
    }

    /**
     * Author: Lawrence
     * Describe:
     *      Coding for customer layout view, after login by username and password which supported,
     *      they can access to get information about their dossiers and allow view track log of those dossiers.
     */
    public function actionCutomerViewDossier($id, $storageID = 1) {
        $criteria = new CDbCriteria();
        $criteria->condition = 'cus_id = :cid';
        $criteria->params = array(
            ':cid' => $id
        );

        $dossierModel = CustomerDossier::model()->findAll($criteria);
        $this->render('customerDossierView', array(
            'dossierModel' => $dossierModel,
        ));
    }

    /**
     * Author: Lawrence
     * Customer Dossier ajax track view */
    public function actionCustomerDossierTrack($did) {
        $criteria = new CDbCriteria();
        $criteria->select = "t.track_id, t.dossier_id, customer_dossier.dossier_name, t.status, t.command, t.create_time";
        $criteria->join = "JOIN customer_dossier ON t.dossier_id = customer_dossier.dossier_id";
        $criteria->condition = "t.dossier_id = :did";
        $criteria->params = array(
            ':did' => $did
        );

        $dossierTrack = DossierTrack::model()->findAll($criteria);
        $json = '{ "aaData" :[';
        foreach ($dossierTrack as $key => $value) {
            $status = "<span class='label label-blue'>Fill In</span>";
            if ($value->status == 2)
                $status = "<span class='label label-red'>Withdraw</span>";
            else if ($value->status == 3)
                $status = "<span class='label label-gray'>Destroy</span>";
            else if ($value->status == 4)
                $status = "<span class='label label-silver'>Change</span>";
            $json .= '{
                    "track_id"  :   "' . $value->track_id . '",
                    "dossier_id" : "' . $value->dossier_id . '",
                    "dossier_name"  : "' . $value->dossier_name . '",
                    "status"    :   "' . $status . '",
                    "command"   :   "' . $value->command . '",
                    "create_time"   :   "' . date('Y-m-d H:i:s', $value->create_time) . '"
                },';
        }
        $json = substr_replace($json, '', -1);
        echo $json .= "] }";
    }

    /**
     * Author: Lawrence
     * Statistic dossier of customer
     */
    private function getReport($id, $month, $year) {
        
    }

    public function actionCustomerDossierStatistic($id, $month = 0, $year = 0) {
        $getAjax = false;
        if (isset($_GET['id']) && isset($_GET['month']) && isset($_GET['year'])) {
            $getAjax = true;
            $id = intval($_GET['id']);
            $month = intval($_GET['month']);
            $year = intval($_GET['year']);
        } else {
            $id = intval($_GET['id']);
            $month = date('m');
            $year = date('Y');
        }

        $model = self::actionReport($id, $month, $year, 'statistic');

        //ajax load statictic - return json format value
        if ($getAjax) {
            $content = '<section>
                        <table class="no-style full" >
                        	<thead>
                        		<tr>
                        			<th></th>
                        			<th width="80" style="text-align: center;">Amount</th>
                        			<th width="100" style="text-align: center;">Price</th>
                        			<th width="100" style="text-align: center;">Total</th>
                        		</tr>
                        	</thead>
                            <tbody>
                                <tr>
                                    <td><b>Box storage full month</b></td>
                                    <td style="text-align: center;">' . $model['boxFull']['amount'] . '</td>
                                    <td class="ta-right">' . number_format($model['boxFull']['price'], 0, 3, '.') . '</td>
                                    <td class="ta-right">';
            $totalFull = intval($model['boxFull']['price']) * intval($model['boxFull']['amount']);
            $content .= number_format($totalFull, 0, 3, '.') . '</td>
                                </tr>
                                <tr>
                                    <td><b>Box storage half month</b></td>
                                    <td style="text-align: center;">' . $model['boxHalf']['amount'] . '</td>
                                    <td class="ta-right">' . number_format($model['boxHalf']['price'], 0, 3, '.') . '</td>
                                    <td class="ta-right">';
            $totalHalf = intval($model['boxHalf']['price']) * intval($model['boxHalf']['amount']);
            $content .= number_format($totalHalf, 0, 3, '.') . '</td>
                                </tr>';

            $total = $totalFull + $totalHalf;
            if (!empty($model['service'])) {
                foreach ($model['service'] as $service) {
                    $total = $total + intval($service->sum);
                    $content .= '<tr>
		                                    <td><b>' . ucfirst($service->name) . '</b></td>
		                                   	<td style="text-align: center;">' . $service->amount . '</td>
		                                    <td class="ta-right">' . number_format($service->price, 0, 3, '.') . '</td>
		                                    <td class="ta-right">' . number_format($service->sum, 0, 3, '.') . '</td>
	                                	</tr>';
                }
            }

            $vat = $total / 100 * 10;
            $sum = $total + $vat;

            $content .= '<tr>
                                    <td colspan="3" class="ta-right">&nbsp;</td>
                                    <td class="ta-right"><b>' . number_format($total, 0, 3, '.') . '</b></td>
                                </tr>
                                <tr>
                                	<td colspan="3" class="ta-right"><b>10% VAT</b></td>
                                    <td class="ta-right"><b>' . number_format($vat, 0, 3, '.') . '</b></td>
                                </tr>
                                <tr>
                                	<td colspan="3" class="ta-right"><b>Total</b></td>
                                    <td class="ta-right"><mark>' . number_format($sum, 0, 3, '.') . '</mark></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>';
            $content;
            $json = json_encode(array(
                'content' => $content,
                'total' => $total
                    ));
            echo $json;
            exit;
        } else {
            $this->render('statisticDossierView', compact('model'));
        }
    }

    /**
     * Author Lawrence
     * Export excel for customer */
    public function actionReport($id, $month, $year, $type = 'download') {
        /*
         * Get data
         */
        // Get Customer Info
        $criteria = new CDbCriteria();
        $criteria->select = "company_name";
        $criteria->condition = "t.cus_id = :id";
        $criteria->params = array(
            ':id' => $id
        );
        $customer = Customer::model()->find($criteria);

        // Get box
        $criteria = new CDbCriteria();
        $criteria->select = "dossier_id, floor_id, status,update_time";
        $criteria->condition = "t.cus_id = :id";
        $criteria->addCondition('YEAR(FROM_UNIXTIME( create_time ))  = :year');
        $criteria->addCondition('MONTH(FROM_UNIXTIME( create_time ))  = :month');
        $criteria->params = array(
            ':id' => $id,
            ':month' => $month,
            ':year' => $year
        );

        $objBox = CustomerDossier::model()->findAll($criteria);
        $boxAmountFull = 0;
        $boxAmountHalf = 0;
        $boxAmount = 0;
        foreach ($objBox as $value) {
            // Amount for get contract_price
            if ($value->status == '1') {
                $boxAmount++;
            }
            // Amount for get full price or half price
            if (($value->status == '0' || $value->floor->status == '2') && date('d', $value->update_time) < 16) {
                $boxAmountHalf++;
            } else {
                $boxAmountFull++;
            }
        }

        $contractPriceHalf = $contractPriceFull = $price = 0;
        if ($boxAmount > 0) {
            // amount for bill price
            $boxAmountPay = $boxAmountHalf + $boxAmountFull;

            // Get contract
            $criteria = new CDbCriteria();
            $criteria->select = "t.price, t.cus_id";
            $criteria->condition = "t.cus_id = :id AND t.contract_flag = 1";
            $criteria->addCondition("SUBSTRING_INDEX(t.contract_range, ' - ', 1) <= :amount1 AND SUBSTRING_INDEX(t.contract_range, ' - ', -1) >= :amount2");
            $criteria->params = array(':id' => $id, ':amount1' => $boxAmount, ':amount2' => $boxAmount);
            $contract = ContractPrice::model()->find($criteria);
            $price = $contract->price;
            $contractPriceFull = $boxAmountFull * $price;
            $contractPriceHalf = $boxAmountHalf * ($price / 2);
        }
        $contractPrice = $contractPriceHalf + $contractPriceFull;

        // Get servie
        $criteria = new CDbCriteria();
        $criteria->select = "service_price.service_id,service_price.service_name as name,service_price.price, create_time, count(service_price.service_id) as amount, SUM(service_price.price) as sum";
        $criteria->condition = "service_price.cus_id = :id";
        $criteria->addCondition('YEAR(FROM_UNIXTIME(create_time))  = :year');
        $criteria->addCondition('MONTH(FROM_UNIXTIME(create_time))  = :month');
        $criteria->addCondition("t.status = 1");
        $criteria->params = array(
            ':id' => $id,
            ':month' => $month,
            ':year' => $year
        );
        $criteria->join = "JOIN service_price ON service_price.service_id = t.service_id";
        $criteria->group = "service_price.service_id,service_price.service_name,service_price.price";
        $objService = DependencePrice::model()->findAll($criteria);

        // Get time report
        $firstDayOfMonth = '1/' . $month . '/' . $year;
        $lastDayOfMonth = $lastDayOfMonth = date("j/n/Y", strtotime("-1 second", strtotime("+1 month", strtotime($month . "/01/" . $year . " 00:00:00"))));

        /*
         * Statisitc
         */
        if ($type == 'statistic') {
            $boxAmountHalf = intval($boxAmountHalf);
            $boxAmountFull = intval($boxAmountFull);
            return array(
                'companyNm' => $customer->company_name,
                'boxFull' => array(
                    'amount' => $boxAmountFull,
                    'price' => ($boxAmountFull > 0) ? intval($price) : 0,
                ),
                'boxHalf' => array(
                    'amount' => $boxAmountHalf,
                    'price' => ($boxAmountHalf > 0) ? intval($price / 2) : 0,
                ),
                'service' => $objService,
            );
        }
        /*
         * Print exel
         */ else {
            Yii::import('application.extensions.excel.PHPExcel');
            Yii::import('application.extensions.excel.PHPExcel.IOFactory');
            // Init obj
            $objPHPExcel = new PHPExcel();
            $objReader = new PHPExcel_Reader_Excel5;

            // Load template
            $path = Yii::app()->theme->basePath . '/template/report_box.xls';
            $objPHPExcel = $objReader->load($path);

            /*
             * Print exel
             */
            // Set data
            $total = 0;
            $objPHPExcel->getActiveSheet()->SetCellValue('A6', ('V/V: DỊCH VỤ LƯU TRỮ HỒ SƠ – KỲ TỪ ' . $firstDayOfMonth . ' ĐẾN ' . $lastDayOfMonth));
            $objRichText = new PHPExcel_RichText();
            $objText1 = $objRichText->createTextRun("Kính gửi:");
            $objText1->getFont()->applyFromArray(
                    array(
                        'underline' => true,
                        'bold' => true,
                        'size' => 13,
                        'name' => 'Times New Roman',
                    )
            );

            $strComp = (strpos(strtolower(preg_replace(array('/\s/', '/(Ã´|Ã”)/'), array('', 'o'), $customer->company_name)), 'congty') == '0') ? '' : ' CÔNG TY ';
            $compNm = $strComp . $customer->company_name;
            $objText2 = $objRichText->createTextRun($compNm);
            $objText2->getFont()->applyFromArray(
                    array(
                        'bold' => true,
                        'size' => 16,
                        'underline' => false,
                        'name' => 'Times New Roman',
                    )
            );
            $objPHPExcel->getActiveSheet()->SetCellValue('A8', $objRichText);
            $objPHPExcel->getActiveSheet()->SetCellValue('B10', ('Căn cứ theo Hợp đồng số ' . $customer->contract_code . ' ngày ' . date('d/m/Y', $customer->contract_time) . ' của Công ty Cổ Phần Không'));
            $objPHPExcel->getActiveSheet()->SetCellValue('A11', ('Gian Quốc Tế (INTERSKY) và ' . $compNm . ' về việc lưu trữ hồ sơ. '));

            // Contract price
            $objPHPExcel->getActiveSheet()->SetCellValue('B16', 'Phí dịch vụ lưu trữ hồ sơ');
            $objPHPExcel->getActiveSheet()->SetCellValue('D16', $boxAmountPay);
            $objPHPExcel->getActiveSheet()->SetCellValue('E16', $price);
            $objPHPExcel->getActiveSheet()->SetCellValue('F16', $contractPrice);
            $total = $contractPrice;
            // Service price
            $i = 17;
            foreach ($objService as $service) {
                $total += $service->sum;
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $i, $service->name);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $i, $service->amount);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $i, $service->price);
                $i++;
            }

            // Fix Template
            $objPHPExcel->getActiveSheet()->removeRow($i, 50 - count($objService));

            $totalVAT = $total * 0.1;
            $totalPay = $total + $totalVAT;
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $i, $total);
            $i++;
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $i, $totalVAT);
            $i++;
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $i, $totalPay);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i + 2), ("(Bằng chữ: " . self::convertMoneyToString(rtrim($totalPay), 0) . " .)"));
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . ($i + 12), ("Tp. HCM ngày " . date('d') . " tháng " . date('m') . " năm " . date('Y')));
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i + 13), ('Xác nhận của bên ' . $compNm));

            //set row height
            $objPHPExcel->getActiveSheet()->getRowDimension(($i + 11))->setRowHeight(15);

            //security in customer mode
            if (Util::intersky_getUserRole(Yii::app()->user->id) == 'Customer') {
                $objPHPExcel->getSecurity()->setLockWindows(true);
                $objPHPExcel->getSecurity()->setLockStructure(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
                $objPHPExcel->getSecurity()->setWorkbookPassword("PHPExcel");
            }

            // Save Excel 2007 file
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $fileName = preg_replace('[\s]', '_', $compNm) . "_" . date('dmYhis', time()) . ".xls";
            $objWriter->save(Yii::getPathOfAlias('webroot') . "/uploads/" . $fileName);

            if (file_exists(Yii::getPathOfAlias('webroot') . "/uploads/" . $fileName)) {
                header('Content-Disposition: attachment; filename=' . $fileName);
                header('Content-Type: application/force-download');
                header('Content-Type: application/octet-stream');
                header('Content-Type: application/download');
                header('Content-Description: File Transfer');
                header('Content-Length: ' . filesize(Yii::getPathOfAlias('webroot') . "/uploads/" . $fileName));
                echo file_get_contents(Yii::getPathOfAlias('webroot') . "/uploads/" . $fileName);
            } else {
                echo "File Download Not Found";
            }
        }
    }

    public function convertMoneyToString($money = 0) {
        $strMoney = "";
        $dilimiter = " ";
        $aCurency = array("đồng", "ngàn", "triệu", "tỉ");
        $aUnit = array("trăm", "mười", "mươi", "lẻ");
        $aNum = array("không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín", "mười", "mốt");
        $aNumSpec = array("1" => "mốt", "5" => "lăm");
        $partMoney = array_reverse(explode('#', number_format($money, 0, 3, '#')));
        if (count($partMoney) > 7) {
            return "Số tiền vượt quá giới hạn!!!";
        }
        foreach ($partMoney as $key => $value) {
            $tempMoney = "";
            $partUnit = str_split(str_pad($value, 3, '0', STR_PAD_LEFT), 1);
            $countUnit = count($partUnit);
            $hundes = $partUnit[0];
            $dozen = $partUnit[1];
            $unit = $partUnit[2];
            // Set hundred
            $tempMoney .= ($hundes > 0 || isset($partMoney[$key + 1])) ? ($aNum[$hundes] . $dilimiter . $aUnit[0] . $dilimiter) : "";

            // Set dozen
            if ($dozen == 0) {
                // lẻ
                $tempMoney .= (($hundes > 0 || isset($partMoney[$key + 1])) && $unit > 0) ? ($aUnit[3] . $dilimiter) : "";
            } else if ($dozen == 1) {
                // mười
                $tempMoney .= $aUnit[1] . $dilimiter;
            } else {
                // mươi
                $tempMoney .= $aNum[$dozen] . $dilimiter . $aUnit[2] . $dilimiter;
            }
            // Set unit
            if ($partUnit[2] > 0) {
                // unit
                $tempMoney .= (($unit == 1 && $dozen > 1) || ($unit == 5 && $dozen > 0)) ? $aNumSpec[$unit] : $aNum[$unit];
            }
            $curency = isset($aCurency[$key]) ? $aCurency[$key] : $aCurency[($key % count($aCurency)) + 1];
            $strMoney = $tempMoney . $dilimiter . $curency . $dilimiter . $strMoney;
        }
        return ucfirst($strMoney);
    }

}
