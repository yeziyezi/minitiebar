<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<?php
$this->title = 'My Bar';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div style="width:50%">
<a href="<?=Url::toRoute(['bar/add'])?>" class="btn btn-primary">创建吧</a><br/>
</div>
<div class="panel panel-default">
  <!-- Default panel contents -->
    <div class="panel-heading">我创建的贴吧</div>
    <!-- <div class="panel-body">
        <p>...</p>
    </div> -->

    <table class="table">
        <?php foreach ($bars as $bar) : ?>
            <tr>
                <td><?=$bar->name?></td>
            </tr>
        <?php endforeach;?>
    </table>
    

</div>