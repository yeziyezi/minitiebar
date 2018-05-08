<?php
use common\models\Reply;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
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
                                <input type="text" name="InnerReply[content]" class="form-control" placeholder="回复楼层" autofocus>
                                <input type="hidden" value="<?=$reply_id?>" name="InnerReply[reply_id]">
                                <input type="hidden" value="<?=Reply::findOne($reply_id)->publishUser->id?>" name="InnerReply[to_user]">
                                <span class="input-group-btn">
                                <input type="hidden" value="0" name="InnerReply[type]">
                                <span class="input-group-btn">
                                    <?= Html::submitButton('回复', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                                </span>
                        </div><!-- /input-group -->
                        <?php ActiveForm::end();?>
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row--> 
            <?php 
            //未登录提示
            else:?>
                <div>登录后可回复</div>
            <?php endif;?>       
        </div>
    </nav>