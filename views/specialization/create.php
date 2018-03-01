<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Specialization */

$this->title = Yii::t('app', 'Create Specialization');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Specializations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="specialization-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
