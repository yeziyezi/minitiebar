<?php
use yii\helpers\Url;
$this->title = '个人资料';
$this->params['breadcrumbs'][] = '个人资料';
?>

<a href="<?=Url::toRoute(['site/request-password-reset'])?>">重置密码</a>
