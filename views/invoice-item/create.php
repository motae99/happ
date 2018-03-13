<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\InvoiceItem */

$this->title = Yii::t('app', 'Create Invoice Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Invoice Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
