<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\Clinic;
/* @var $this yii\web\View */
/* @var $model app\models\Physician */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="physician-form">

    <?php $form =  ActiveForm::begin(['id' => 'dynamic-form']);?>
    <div class="row">
        <div class="col-lg-8">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'contact_no')->textInput() ?>
        </div>
        <div class="col-lg-12">
            <?= $form->field($model, 'email')->textInput() ?>
        </div>
    </div>

    

    <?php //echo $form->field($insurance, 'insurance_id')->textInput() ?>
    <?php //echo $form->field($insurance, 'patient_payment')->textInput() ?>
    <?php //echo $form->field($insurance, 'insurance_refund')->textInput() ?>
    <?php //echo $form->field($insurance, 'contract_expiry')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
