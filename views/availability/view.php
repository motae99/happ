<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Availability */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Availabilities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="availability-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'physician_id',
            'clinic_id',
            'date',
            'from_time',
            'to_time',
            'appointment_fee',
            'revisiting_fee',
            'max',
            'status',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
