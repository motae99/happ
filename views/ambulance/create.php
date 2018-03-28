<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ambulance */

$this->title = Yii::t('app', 'Create Ambulance');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ambulances'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ambulance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
