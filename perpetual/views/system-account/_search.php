<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SystemAccountSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="system-account-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'account_no') ?>

    <?= $form->field($model, 'system_account_name') ?>

    <?= $form->field($model, 'account_type_id') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'opening_balance') ?>

    <?php // echo $form->field($model, 'balance') ?>

    <?php // echo $form->field($model, 'group') ?>

    <?php // echo $form->field($model, 'to_increase') ?>

    <?php // echo $form->field($model, 'color_class') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
