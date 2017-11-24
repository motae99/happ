<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Inventory */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Inventories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('<i class="fa fa-edit"> Update This</i>', ['value' => Url::to(['inventory/update', 'id' => $model->id]), 'title' => 'update', 'class' => 'btn btn-flat bg-yellow showModalButton']); ?>
        
        <?= Html::a(Yii::t('app', 'Invoice'), ['invoices/create', 'id' => $model->id], [
            'class' => 'btn btn-danger',]) 
        ?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'address:ntext',
        ],
    ]) ?>

</div>
