<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Clinic */

$this->title = Yii::t('app', 'Create Clinic');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Clinics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clinic-create">

    <h1></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
