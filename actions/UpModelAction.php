<?php
/**
 * Created by JetBrains PhpStorm.
 * User: antonio<antonio.lightsoft@gmail.com>
 * Date: 12.02.14
 * Time: 19:58
 * To change this template use File | Settings | File Templates.
 */

namespace application\helpers\actions;


class UpModelAction extends \CAction{

    public $modelClass;
    public $view='create';
    public $redirectUrl='';

    public function run($id=null){
        if($id){
            $model=$this->getController()->loadModel($id, $this->modelClass);
        }else{
            $model=new $this->modelClass();
        }

        if($data=\Rb::app()->request->getPost(get_class($model))){
            $model->setAttributes($data);
            if($model->save()){
                $this->getController()->redirect($this->redirectUrl);
            }
        }
        $this->getController()->render($this->view, array('model'=>$model));
    }
}