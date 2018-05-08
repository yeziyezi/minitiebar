<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php
$this->params['breadcrumbs'][] = ['label'=>$barName.'吧','url'=>['bar/index']];
$this->params['breadcrumbs'][] = '发贴';

?>

<?php $form=ActiveForm::begin();?>
    <?=$form->field($model,'title')->textInput(['autofocus'=>true])?>
    <?=$form->field($model,'content')->textarea(['rows'=>8])?>
    <div class="form-group">
        <?= Html::submitButton('发贴', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>
<?php ActiveForm::end();?>


