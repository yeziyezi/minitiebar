<?php
use yii\widgets\ListView;
use yii\helpers\Url;
$this->params['breadcrumbs'][] = $bar_name.'吧';
?>
<a class="btn btn-primary"  role="button" href="<?=Url::to(['post/add','bar-name'=>$bar_name])?>"
    ><span class="glyphicon glyphicon-comment"></span>发布贴子</a>
<div class="row">
    <div class="col-md-12">
        <?=ListView::widget([
            'dataProvider'=>$dataProvider,
            'itemView'=>'_listpost',
            'pager'=>[
                'maxButtonCount'=>10,
                'firstPageLabel' => '首页',
                'prevPageLabel' => '上一页',
                'nextPageLabel' => '下一页',
                'lastPageLabel' => '尾页'
            ]
        ])?>
    </div>
</div>
