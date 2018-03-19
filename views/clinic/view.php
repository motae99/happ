<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Clinic */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Clinics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clinic-view">

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
            'primary_contact',
            'secondary_contact',
            'longitude:ntext',
            'latitude:ntext',
            'type',
            'start',
            'end',
            // 'application_service',
        ],
    ]) ?>

    <?php Html::img($model->getPhoto($model->photo.$model->id),['alt'=>'No Image', 'class'=>'img-circle']); ?>

</div>
