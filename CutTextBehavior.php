<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CutTextBehavior
 *
 * @author antonio
 */
class CutTextBehavior extends \CActiveRecordBehavior{
    //put your code here
    
    public $text='text';


    public function getCutText($length=200){
        $text = eh($this->getOwner()->{$this->text});
        $cutText = mb_substr($text, 0, $length);
        $cutText = ($cutText != $text)?  $cutText.' ...' : $text;
        return $cutText;
    }
    
    public function getIsShowFullText($length=200){
        $text = eh($this->getOwner()->{$this->text});
        return $text !== $this->getCutText($length);
    }
}
