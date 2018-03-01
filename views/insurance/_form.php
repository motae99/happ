<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Insurance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="insurance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'appointment_discount')->textInput() ?>

    <?= $form->field($model, 'appointment_cap')->textInput() ?>

    <?= $form->field($model, 'drug_discount')->textInput() ?>

    <?= $form->field($model, 'drug_cap')->textInput() ?>

    <?= $form->field($model, 'surgery_discount')->textInput() ?>

    <?= $form->field($model, 'surgery_cap')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
