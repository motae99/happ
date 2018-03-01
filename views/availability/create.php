<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Availability */

$this->title = Yii::t('app', 'Create Availability');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Availabilities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="availability-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
