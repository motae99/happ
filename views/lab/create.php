<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Lab */

$this->title = Yii::t('app', 'Create Lab');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Labs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lab-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
