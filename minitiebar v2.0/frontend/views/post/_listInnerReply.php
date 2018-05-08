<?php
$fromUser=$model->publishUser->nickname;
$toUser=$model->toUser->nickname;
?>
<?php if($model->type===1):?>
<?=$fromUser?> 回复 <?=$toUser?> : <?=$model->content?> <a             
            onclick="renderNewReplyNavbar('innerReply','<?=$model->id?>')"
            >回复</a>
<?php elseif($model->type=1):?>
<?=$fromUser?> : <?=$model->content?> <a             
            onclick="renderNewReplyNavbar('innerReply','<?=$model->id?>')"
            >回复</a>
<?php endif;?>