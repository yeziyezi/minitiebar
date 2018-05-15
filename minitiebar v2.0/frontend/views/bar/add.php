<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form=ActiveForm::begin();?>
<?=$form->field($model,'name')->textInput(['autofocus'=>true])?>
<?=$form->field($model,'intro')->textInput()?>
<?=Html::submitButton('创建',['class'=>'btn btn-primary'])?>
<?php ActiveForm::end();?>