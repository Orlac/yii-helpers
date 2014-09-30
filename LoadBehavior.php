<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoadBehavior
 *
 * @author antonio
 */
class LoadBehavior extends \CActiveRecordBehavior{
    //put your code here
    
    public function loadByPk($pk) {
        $model = $this->getOwner()->findByPk($pk);
        if ($model == null) {
			throw new CHttpException(404);
		}
		return $model;
    }
}
