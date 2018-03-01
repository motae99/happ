<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Patient */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="patient-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_no')->textInput() ?>

    <?= $form->field($model, 'gender')->dropDownList([ 'male' => 'Male', 'female' => 'Female', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'martial_status')->dropDownList([ 'married' => 'Married', 'single' => 'Single', 'divorced' => 'Divorced', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'has_insurance')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'insurance_id')->textInput() ?>

    <?= $form->field($model, 'insurance_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valid_till')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
