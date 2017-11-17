<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SystemAccount */

$this->title = Yii::t('app', 'Create System Account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-account-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
