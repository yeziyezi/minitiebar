<?php
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

?>

    <?=Breadcrumbs::widget([
    'homeLink' => ['label' => '首页', 'url' => Yii::$app->homeUrl],
    'links' => [
        [
            'label' => $bar_name.'吧',
            'url' => ['post/list','bar-name'=>$bar_name],
        ],
        [
            'label' => $model->title,
        ],
    ],
]);?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>&nbsp;<?= $model->title ?></h3>
            <span class="glyphicon glyphicon-user"></span>&nbsp;<?= $model->publishUser->nickname ?>
            <span class="glyphicon glyphicon-time"></span>&nbsp;<?= $model->last_reply_time ?>
        </div>
        <div class="panel-body">
            <p><?= nl2br($model->content) ?></p>
        </div>
    </div>
    <a class="btn btn-primary"  role="button" data-pjax='' 
    onclick="renderNewReplyNavbar('post','<?= $post_id ?>')"
    ><span class="glyphicon glyphicon-comment"></span> 回复贴子</a>

    <?php if(!Yii::$app->user->isGuest&&Yii::$app->user->id===$model->publishUser->id):?>
        <a class="btn btn-danger"  role="button"
        onclick="deleteDivAlert('<?=$model->id?>')" data-dismiss="alert"
        ><span class="glyphicon glyphicon-remove-sign"></span> 删除贴子</a>

        <div id="alertDiv"></div>
        

    <?php endif;?>

    <br/>

    <?php if (count($model->replies) > 0) : ?>
        <?= ListView::widget([
            'dataProvider' => $replyDataProvider,
            'itemView' => '_listreply',
            'pager' => [
                'maxButtonCount' => 10,
                'firstPageLabel' => '首页',
                'prevPageLabel' => '上一页',
                'nextPageLabel' => '下一页',
                'lastPageLabel' => '尾页'
            ]
        ]) ?>
    <?php else : ?> 
    此贴子尚无回复，快来抢沙发吧！   
    <?php endif; ?>
    

    <?php Pjax::begin(['id' => 'replyNavbar']) ?>

    <?= $replyXNavbar ?> 

    <?php Pjax::end() ?>


    

    <script>
        function renderNewReplyNavbar(type,id){
            $.pjax.reload({
                container:"#replyNavbar",url:'<?= Url::to(['detail', 'post_id' => $post_id]) ?>',data:{
                    type:type,
                    id:id
                }
            });
        }
        function deleteReply(reply_id){
            $.post({
                url:'<?=Url::toRoute(['reply/delete'])?>',
                data:{
                    'reply_id':reply_id
                },
                success:function(data){
                    if(data=='true'){
                        alert('删除成功！');
                        window.location.reload(true);
                    }else{
                        alert('删除失败');
                    }
                }
            });
        }
    </script>

    <?php if(!Yii::$app->user->isGuest&&Yii::$app->user->id===$model->publishUser->id):?>
        <script>       
            function deleteDivAlert(post_id){
                $("#alertDiv").empty();
                $("#alertDiv").append('<br/><div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"></button><h4>确认要删除贴子吗？</h4><p><button type="button" class="btn btn-danger" onclick="submitDelete()">删除</button> <button type="button" class="btn btn-default" onclick="closeAlert()">取消</button></p></div></div>');
            }
            function submitDelete(){
                $.post({
                    url:'<?=Url::toRoute(['post/delete','post_id'=>$model->id])?>',
                    success:function(data){
                        if(data=='true'){
                            alert('删除成功 !');
                            $(".alert").alert('close');
                            $("#alertDiv").empty();
                            window.location.href="<?=Url::to(['post/list','bar-name'=>$model->bar->name])?>";
                        }                        
                    }
                });
            }
            function closeAlert(){
                $(".alert").alert('close');
                $("#alertDiv").empty();
            }
        </script>
    <?php endif;?>

    

    