<?php
namespace frontend\controllers;
use yii\web\Controller;
use common\models\BarSearch;
class BarController extends Controller{
    function actionIndex(){
        return $this->render('index');
    }
    function actionList(){
        $searchModel=new BarSearch();
        $dataProvider=$searchModel->search([]);
        return $this->render('list',[
            'dataProvider'=>$dataProvider,
        ]);
    }  
}