<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AvailabilitySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="availability-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'physician_id') ?>

    <?= $form->field($model, 'clinic_id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'from_time') ?>

    <?php // echo $form->field($model, 'to_time') ?>

    <?php // echo $form->field($model, 'appointment_fee') ?>

    <?php // echo $form->field($model, 'revisiting_fee') ?>

    <?php // echo $form->field($model, 'max') ?>

    <?php // echo $form->field($model, 'status') ?>

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
