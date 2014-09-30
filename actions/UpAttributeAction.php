<?php
/**
 * Created by JetBrains PhpStorm.
 * User: antonio<antonio.lightsoft@gmail.com>
 * Date: 08.02.14
 * Time: 19:55
 * To change this template use File | Settings | File Templates.
 */

namespace application\helpers\actions;

/**
 * @property callable $reqAttribute
 * @property callable $callBack
 */
class UpAttributeAction extends \CAction{

    public $modelClass;
    public $reqAttribute;
    public $callBack;
    public $security;

    public function run($id){
        try{

            if($this->security){
                $owner = $this->getController();
                $ensureAccess = new \ReflectionMethod($owner, 'ensureAccess');
                $ensureAccess->setAccessible(true);
                $res=call_user_func($this->security, $id);
                $ensureAccess->invoke($owner, $res );
            }

            $model=$this->getController()->loadModel($id, $this->modelClass);
            $attribute=\Rb::app()->request->getQuery($this->reqAttribute);

            //if(!$this->callBack($model, $attribute) ){
            if(!$model->{$this->callBack}($attribute) ){
                throw new \CException(\CHtml::errorSummary($model));
            }
            echo json_encode(array('success'=>1));
        }catch (\Exception $e){
            echo json_encode(array('success'=>0, 'error'=>$e->getMessage()));
        }
    }
}