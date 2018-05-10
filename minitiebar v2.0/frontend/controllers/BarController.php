<?php
namespace frontend\controllers;
use yii\web\Controller;
use common\models\Bar;
class BarController extends Controller{
    function actionIndex(){
        return $this->render('index');
    }
    function actionList(){
        $bars=Bar::find()->orderBy('post_number DESC')->all();
        $list=[];
        foreach($bars as $bar){
            $list[]=$bar->name;
        }
        return $this->render('list',[
            'list'=>$list,
        ]);
    }  
}