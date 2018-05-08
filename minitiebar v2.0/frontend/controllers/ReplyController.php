<?php
namespace frontend\controllers;
use yii\web\Controller;
use Yii;
use common\models\Reply;
use yii\web\HttpException;
use yii\base\Security;
use yii\helpers\Html;
class ReplyController extends Controller{
    public function actionAdd(){
        $model=new Reply();
        if($model->load(Yii::$app->request->post())){
            $model->content=Html::encode($model->content);
            $model->publish_time=Date('Y-m-d H:i:s');
            $uuid=(new Security())->generateRandomString(36);
            $model->id='r-'.$uuid;
            $model->publish_user=Yii::$app->user->id;
            if($model->validate()&&$model->save()){
                $this->redirect(['post/detail','post_id'=>$model->post_id]);
            }else{
                throw new HttpException(500,'回复失败');
            }
        }
    }
    
}