<?php
use yii\helpers\Url;

$post_id = $model->id;
$detailUrl = Url::to(['post/detail', 'post_id' => $post_id]);
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <a href=<?= $detailUrl ?>>
            <h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;<?= $model->title ?></h3>
            <span class="glyphicon glyphicon-user"></span>&nbsp;<?= $model->publishUser->nickname ?>
            <span class="glyphicon glyphicon-time"></span>&nbsp;<?= $model->last_reply_time ?>
            <span class="glyphicon glyphicon-comment"></span>&nbsp;<?= $model->reply_number?>

        </a> 
        </div>
        <div class="panel-body">
            <?php
            $content = $model->content;
            if (mb_strlen($content) > 100) {
                $content = mb_substr($content, 0, 100) . "...";
            }
            echo $content;
            ?>
        </div>
</div>