<?php
use yii\helpers\Url;
use common\models\InnerReplySearch;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use common\models\Reply;
$innerReplyDataProvider=new ActiveDataProvider([
    'query'=>InnerReplySearch::find()->where(['reply_id'=>$model->id])->orderBy('publish_time'),
    'pagination'=>[
        'pagesize'=>10,
    ]
]); 
?>
            
<div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-user"></span>&nbsp;<?=$model->publishUser->nickname?>
            <span class="glyphicon glyphicon-time"></span>&nbsp;<?=
            date('Y-m-d H:i',strtotime($model->publish_time))?>
            

            <?php             
                if(!Yii::$app->user->isGuest&&Yii::$app->user->id===$model->publishUser->id||Yii::$app->user->id===$model->post->publishUser->id):?>
                <a onclick="deleteReply('<?=$model->id?>')">
                <span style="float:right">&nbsp;删除&nbsp;</span></a>
            <?php endif;?>

            <a onclick="renderNewReplyNavbar('reply','<?=$model->id?>')">
            <span style="float:right">&nbsp;回复&nbsp;</span></a>
        </div>
    <div class="panel-body">
        <?=$model->content?>  
        <?php if(count($model->innerReplies)>0):?>
            <br/>
            <br/>
            <div class="well">
                <?=ListView::widget([
                    'dataProvider'=>$innerReplyDataProvider,
                    'itemView'=>'_listInnerReply',
                ])?>
            </div>
        <?php endif;?>
    </div>
    
</div>


