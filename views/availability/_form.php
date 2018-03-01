<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Availability */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="availability-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'physician_id')->textInput() ?>

    <?= $form->field($model, 'clinic_id')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'from_time')->textInput() ?>

    <?= $form->field($model, 'to_time')->textInput() ?>

    <?= $form->field($model, 'appointment_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'revisiting_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'max')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ '0', '1', '2', '3', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
