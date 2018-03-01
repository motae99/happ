<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\InsuranceAcceptance */

$this->title = Yii::t('app', 'Create Insurance Acceptance');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Insurance Acceptances'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="insurance-acceptance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
