<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\InsuranceAcceptance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="insurance-acceptance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'availability_id')->textInput() ?>

    <?= $form->field($model, 'insurance_id')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
