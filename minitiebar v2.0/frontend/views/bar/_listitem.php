<?php
use yii\helpers\Html;
?>
<div class="panel panel-default">
    <div class="panel-body">
        <?=Html::a(Html::encode($model->name),['post/list','bar-name'=>$model->name])?>
        <?=Html::a('发贴',['post/add','bar-name'=>$model->name])?> 
    </div>

</div>
