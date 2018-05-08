<?php
use common\models\Reply;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\InnerReply;
?>

<!--回复当前贴子的底端浮动回复框-->
<nav class="navbar navbar-default navbar-fixed-bottom " id="reply-post-form">
        <div class="container">
            <?php 
            //如果已登录，显示浮动回复框
            if(!Yii::$app->user->isGuest):?>
                <div class="row">
                    <div class="col-lg-6">
                        <?php $form=ActiveForm::begin(['action'=>['inner-reply/add']])?>  
                        <div class="input-group">
                                <input type="text" name="InnerReply[content]" class="form-control" placeholder="回复 <?=InnerReply::findOne($inner_reply_id)->publishUser->nickname?>" autofocus>
                                <input type="hidden" value="<?=InnerReply::findOne($inner_reply_id)->reply->id?>" name="InnerReply[reply_id]">
                                <input type="hidden" value="<?=InnerReply::findOne($inner_reply_id)->publishUser->id?>" name="InnerReply[to_user]">
                                <span class="input-group-btn">
                                <input type="hidden" value="1" name="InnerReply[type]">
                                <span class="input-group-btn">
                                    <?= Html::submitButton('回复', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                                </span>
                        </div>
                        <?php ActiveForm::end();?>
                    </div>
                </div>
            <?php 
            //未登录提示
            else:?>
                <div>登录后可回复</div>
            <?php endif;?>       
        </div>
    </nav>