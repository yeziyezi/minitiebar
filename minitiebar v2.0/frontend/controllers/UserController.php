<?php
namespace frontend\controllers;
use yii\web\Controller;
use Yii;
use common\models\User;
class UserController extends Controller{

    function actionView(){//个人资料修改页
        return $this->render('view',[
        ]);
    }

    function actionUpdateNickname(){
        $userModel=User::findOne(Yii::$app->user->id);
        if($userModel->load(Yii::$app->request->post())&&$userModel->validate()){
            $userModel->save();
            $this->redirect(['view']);
        }
        return $this->render('updateNickname',[
            'model'=>$userModel,
        ]);
    }

    function actionMybar(){//贴吧操作页，可以创建吧，其他功能待添加
        $user=User::findOne(Yii::$app->user->id);
        $bars=$user->bars;
        return $this->render('mybar',[
            'bars'=>$bars,
        ]);
    }
}