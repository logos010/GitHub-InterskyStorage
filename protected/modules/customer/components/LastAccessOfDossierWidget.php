<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LasrAccessOfDossierWidget
 *
 * @author Lawrence
 */
class LastAccessOfDossierWidget extends CWidget {
    
    public function run(){
        Yii::import('application.modules.customer.models.*');
        $criteria = new CDbCriteria();
        $criteria->condition = "status = 1";
        $criteria->order = "create_time, update_time DESC";
        $criteria->limit = "5";
        
        $customerDossiers = CustomerDossier::model()->findAll($criteria);

        $this->render('LastAccessOfDossierWidget', array(
            'customerDossiers' => $customerDossiers,
        ));
    }
}

?>
