<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DrugSupplier */

$this->title = Yii::t('app', 'Create Drug Supplier');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Drug Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="drug-supplier-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
