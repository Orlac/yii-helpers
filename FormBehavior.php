<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormBehavior
 *
 * @author antonio
 */
class FormBehavior extends CModelBehavior{
    //put your code here
    
    public function setLoadAttributes($inputData){
        $data = $this->getInputData($inputData);
        if($data){
            $this->getOwner()->setAttributes( (array) $data);
        }
    }
    
    public function getInputData($inputData){
        $nameAttr = get_class( $this->getOwner() );
        $data = \CArray::element( $nameAttr, $inputData );
        if($data){
            return (array) $data;
        }else{
            $nameAttr = preg_replace('/\\\/ims', '_', $nameAttr);
            $data = \CArray::element( $nameAttr, $inputData );
            if($data){
                return (array) $data;
            }
        }
    }
    
    public function getInputParam(){
        $nameAttr = get_class( $this->getOwner() );
//        return $nameAttr;
        return preg_replace('/\\\/ims', '_', $nameAttr);
    }
    
    /**
     * хоть один атрибут формы загружен
     */
    public function getIsLoadedAttributes($ignoreAttrs=array()) {
        /* @var $form CFormModel */
        $form=  $this->getOwner();
        foreach ($form->attributeNames() as $attr){
            if(!in_array($attr, $ignoreAttrs)){
                if($form->{$attr}){
                    return true;
                }
            }
        }
        return false;
        
    }
}
