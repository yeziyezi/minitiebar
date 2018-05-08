<?php
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
?>
<div class="row">
    <div class="col-md-12">
        <?=ListView::widget([
            'dataProvider'=>$dataProvider,
            'itemView'=>'_listitem',
        ])?>
    </div>
</div>