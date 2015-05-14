<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LastVisitedUserWidget
 *
 * @author Lawrence
 */
class LastVisitedUserWidget extends CWidget{
    
    public function run(){
        $criteria = new CDbCriteria();
        $criteria->order = "lastvisit_at DESC";
        $criteria->limit = 5;
        
        $lastVisited = User::model()->findAll($criteria);
        $this->render('LastVisitedUserWidget', array('lastVisited' => $lastVisited));
    }
}

?>
