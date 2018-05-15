<?php
namespace frontend\controllers;
use yii\web\Controller;
use common\models\Bar;
use common\models\User;
use Yii;
use yii\base\Security;
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
    function actionAdd(){
        $bar = new Bar();
        if($bar->load(Yii::$app->request->post())){
            $bar->id='bar-'.(new Security())->generateRandomString(36);
            $bar->create_time=date('Y-m-d H:i:s');
            $bar->create_user=Yii::$app->user->id;
            if($bar->validate()&&$bar->save()){
                return $this->redirect(['user/mybar']);
            }
        }
        
        return $this->render('add',[
                'model'=>$bar
        ]);
    }
    function actionUpdate(){
       
    }
    
}