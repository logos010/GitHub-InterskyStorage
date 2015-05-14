<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ContainFloorWidget
 *
 * @author Lawrence
 */
Yii::import('application.modules.customer.models.CustomerDossier');
Yii::import('application.modules.customer.models.Customer');

class ContainFloorWidget extends CWidget{

    public $cid, $rid, $selectDossier, $currentId, $oldId;

    public function run() {
        $criteria = new CDbCriteria();
        $criteria->condition = 'contain_id = :cid AND range_id = :rid';
        $criteria->params = array(
            ':cid' => $this->cid,
            ':rid' => $this->rid,
        );
        $floors = Floor::model()->findAll($criteria);
        $this->render('ContainFloorWidget', array(
            'floors' => $floors,
        	'selectDossier' => $this->selectDossier,
        	'currentId'	=> $this->currentId,
        	'oldId'		=> $this->oldId,
        ));
    }

}

?>
