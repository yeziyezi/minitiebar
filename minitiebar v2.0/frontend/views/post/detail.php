<?php
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\widgets\Pjax;
?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>&nbsp;<?= $model->title ?></h3>
            <span class="glyphicon glyphicon-user"></span>&nbsp;<?= $model->publishUser->nickname ?>
            <span class="glyphicon glyphicon-time"></span>&nbsp;<?= $model->last_reply_time ?>
        </div>
        <div class="panel-body">
            <p><?= $model->content ?></p>
        </div>
    </div>
    <a class="btn btn-primary"  role="button" data-pjax='' 
    onclick="renderNewReplyNavbar('post','<?= $post_id ?>')"
    ><span class="glyphicon glyphicon-comment"></span>回复贴子</a>
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
                container:"#replyNavbar",url:'<?= Url::to(['detail', 'post_id' => $post_id, '#' => 'jumphere!']) ?>',data:{
                    type:type,
                    id:id
                }
            });
        }
    </script>
    <script>
    $(function(){
    var url = window.location.toString();
    var id = url.split("#")[1];
    if(id){
        var t = $("#"+id).offset().top;
        $(window).scrollTop(t);
    }		   
});

function getScrollOffsets(w){  
  w=w || window;  
  //除了IE8以及更早的版本，其它浏览器都能用  
  if(w.pageXOffset != null){  
    return { x:w.pageXOffset, y:w.pageYOffset }  
  }  
    
  //对标准模式下的IE或任何浏览器  
  var d=w.document;  
  if(document.compatMode == "CSS1Compat"){  
    return { x:d.documentElement.scrollLeft ,y:d.documentElement.scrollTop }  
  }  
  
  //对怪异模式下的浏览器  
  return { x:d.body.scrollLeft, y:d.body.scrollTop }  
    
}  
// function alertOffset(){
//     var offset=getScrollOffsets();
//     alert(offset.x+'-'+offset.y);
// }
function scrollTo(offset){
    $("html,body").animate({scrollTop:offset}, 1000);//无法正常漂移，找其他方法

}
function scroll(){
    $("html,body").animate({scrollTop: $("#box").offset().top}, 1000);

}
    </script>
    


    

    