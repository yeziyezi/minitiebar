<?php
namespace frontend\controllers;

use yii\web\Controller;
use Yii;
use common\models\Reply;
use yii\web\HttpException;
use yii\base\Security;
use yii\helpers\Html;
use common\models\InnerReply;

class ReplyController extends Controller
{
    public function actionAdd()
    {
        $model = new Reply();
        if ($model->load(Yii::$app->request->post())) {
            $model->content = Html::encode($model->content);
            $model->publish_time = Date('Y-m-d H:i:s');
            $uuid = (new Security())->generateRandomString(36);
            $model->id = 'r-' . $uuid;
            $model->publish_user = Yii::$app->user->id;
            if ($model->validate() && $model->save()) {
                $post = $model->post;
                $post->reply_number++;
                $post->save();
                $this->redirect(['post/detail', 'post_id' => $model->post_id]);
            } elseif ($model->content === '') {
                throw new HttpException(500, '回复不能为空！');
            } else {
                throw new HttpException(500, '回复失败');
            }
        }
    }

    public function actionDelete()
    {

        if (Yii::$app->request->isAjax) {
            $reply_id = Yii::$app->request->post('reply_id');
            $reply = Reply::findOne($reply_id);
            $reply_publisher = $reply->publishUser->id;
            $post_publisher = $reply->post->publishUser->id;
            $logined_user = Yii::$app->user->id;

            if ($logined_user === $reply_publisher || $logined_user === $post_publisher) {

                $transaction = $reply->getDb()->beginTransaction();
                try{
                    if(count($reply->innerReplies)>0){
                        InnerReply::deleteAll(['reply_id' => $reply_id]);
                    }
                    $reply->delete();
                    $post = $reply->post;
                    if ($post->reply_number > 0) {
                        $post->reply_number--;
                        $post->save();
                    }
                    $transaction->commit();
                    echo 'true';
                }catch (\Throwable $e) {
                    $transaction->rollBack();
                    echo 'false';
                }
            } else {
                echo 'false';
            }
        }
    }

}