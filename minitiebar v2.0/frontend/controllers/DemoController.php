<?php
namespace frontend\controllers;

use yii\web\Controller;

class DemoController extends Controller{
    public function actionTime(){
        return $this->render('/post/detail',[
            'time'=>time()
        ]);
    }
}