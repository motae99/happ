<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PharmacySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pharmacy-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'state') ?>

    <?= $form->field($model, 'city') ?>

    <?= $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'working_days') ?>

    <?php // echo $form->field($model, 'from_hour') ?>

    <?php // echo $form->field($model, 'to_hour') ?>

    <?php // echo $form->field($model, 'app_service') ?>

    <?php // echo $form->field($model, 'logitude') ?>

    <?php // echo $form->field($model, 'latitude') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'rate') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
