<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ClientAccount */

$this->title = Yii::t('app', 'Create Client Account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Client Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-account-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
