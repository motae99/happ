<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\InvoiceProduct */

$this->title = Yii::t('app', 'Create Invoice Product');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Invoice Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
