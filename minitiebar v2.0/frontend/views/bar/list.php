<?php
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
$bar_count=count($list);
?>

<ul class="list-group">
    <?php for($index=0;$index<$bar_count;$index++):?>
        <?php if($index%2===0):?>
            <li class="list-group-item" style="width:50%;float:left">
                <?=Html::a(Html::encode($list[$index]),['post/list','bar-name'=>$list[$index]])?>
            </li>
        <?php else:?>
            <li class="list-group-item" style="width:50%;float:right">
                <?=Html::a(Html::encode($list[$index]),['post/list','bar-name'=>$list[$index]])?>
            </li>
        <?php endif;?>
    <?php endfor;?>
</ul>