<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;   
?>
<?php
$this->title='修改昵称';
$this->params['breadcrumbs'][] = [
    'url'=>Url::toRoute(['user/view']),
    'label'=>'个人资料'
];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?=$this->title?></h1>
<?php $form=ActiveForm::begin();?>
<?=$form->field($model,'nickname')->textInput(['value'=>$model->nickname,'autofocus'=>true])?>
<?=Html::submitButton('修改', ['class' => 'btn btn-primary'])?>
<?php ActiveForm::end();?>