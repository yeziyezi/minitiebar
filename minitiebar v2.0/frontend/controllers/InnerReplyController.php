<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\helpers\Html;
use yii\base\Security;
use common\models\InnerReply;
use Yii;
use yii\web\HttpException;
class InnerReplyController extends Controller{
    
    function actionList(){
        
    }
    public function actionAdd(){
        $model=new InnerReply();
        if($model->load(Yii::$app->request->post())){
            $model->content=Html::encode($model->content);
            $model->publish_time=Date('Y-m-d H:i:s');
            $uuid=(new Security())->generateRandomString(36);
            $model->id='ir-'.$uuid;
            $model->publish_user=Yii::$app->user->id;

            if($model->validate()&&$model->save()){
                $post_id=$model->reply->post->id;
                $this->redirect(['post/detail','post_id'=>$post_id]);
            }else{
                print_r($model->errors);
                exit;
                throw new HttpException(500,'回复失败！');
            }
        }
    }
}