<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SystemAccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="system-account-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'account_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'system_account_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'account_type_id')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'opening_balance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'balance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'group')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to_increase')->dropDownList([ 'depit' => 'Depit', 'credit' => 'Credit', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'color_class')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
