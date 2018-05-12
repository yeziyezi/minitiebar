<?php
namespace frontend\controllers;
use yii\web\Controller;
use Yii;
class UserController extends Controller{

    function actionView(){//个人资料修改页
        return $this->render('view',[
            'user'=>Yii::$app->user,
        ]);
    }
}