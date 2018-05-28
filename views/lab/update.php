<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;use kartik\select2\Select2;
use kartik\time\TimePicker; 


/* @var $this yii\web\View */
/* @var $model app\models\Clinic */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="lab-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'الأسم')])->label(false) ?>
    
     <?= $form->field($model, 'state')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'الوﻻية')])->label(false) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'المدينة')])->label(false) ?>
    
    <?= $form->field($model, 'address')->textarea(['rows' => 2, 'placeholder' => Yii::t('app', 'العنوان')])->label(false) ?>

    <?= $form->field($model, 'phone')->textInput(['type' => 'number', 'max' => 999999999999, 'placeholder' => Yii::t('app', 'تلفون ')])->label(false) ?>

    <?= $form->field($model, 'secondary_phone')->textInput(['type' => 'number', 'max' => 999999999999, 'placeholder' => Yii::t('app', 'تلفون ')])->label(false) ?>

    <?= $form->field($model, 'logitude')->textInput(['placeholder'=> Yii::t('app', 'خط الطول')])->label(false) ?>
    
    <?= $form->field($model, 'latitude')->textInput(['placeholder'=> Yii::t('app', 'خط العرض')])->label(false) ?>
    

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
