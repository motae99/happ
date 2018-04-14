<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pharmacy */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pharmacies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pharmacy-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
       
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'state',
            'city',
            'address:ntext',
            'working_days:ntext',
            'from_hour',
            'to_hour',
            'app_service',
            'logitude:ntext',
            'latitude:ntext',
            'phone',
            'rate',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>

    <?= Html::button('<i class="fa fa-plus"></i>', ['value' => Url::to(['insu', 'id' => $model->id]), 'title' => Yii::t('app', 'اضف تأمين'), 'class' => 'btn btn-flat bg-blue showModalButton']); ?>
    <?= Html::button('<i class="fa fa-plus"></i>', ['value' => Url::to(['drug', 'id' => $model->id]), 'title' => Yii::t('app', 'اضف منتج'), 'class' => 'btn btn-flat bg-purple showModalButton']); ?>
