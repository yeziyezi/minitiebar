<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\helpers\Html;
use yii\base\Security;
use common\models\InnerReply;
use Yii;
use yii\web\HttpException;
use common\models\Post;
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
                $post=Post::findOne($post_id);
                $post->reply_number++;
                $post->save();
                $this->redirect(['post/detail','post_id'=>$post_id]);
            }elseif($model->content===''){
                throw new HttpException(500,'回复不能为空！');
            }else{
                throw new HttpException(500,'回复失败！');
            }
        }
    }
}