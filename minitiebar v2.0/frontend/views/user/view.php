<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<?php
$this->title = '个人资料';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div style="width:50%">
<a href="<?=Url::toRoute(['site/request-password-reset'])?>" class="btn btn-primary btn-lg btn-block">重置密码</a><br/>
<a href="<?=Url::toRoute(['user/update-nickname'])?>" class="btn btn-primary btn-lg btn-block">修改昵称</a><br/>
</div>
