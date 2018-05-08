<?php
use yii\widgets\ListView;
?>
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
