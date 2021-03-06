<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2; 
use kartik\time\TimePicker; 


/* @var $this yii\web\View */
/* @var $model app\models\Pharmacy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pharmacy-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'phone')->textInput(['type' => 'number', 'max' => 9999999999,]) ?>

    <?= $form->field($model, 'owner_name')->textInput(['placeholder' => 'أسم صاحب الرخصة'])->label(false) ?>

    <?= $form->field($model, 'website')->textInput(['placeholder' => 'الموقع الالكتروني'])->label(false) ?>

    <?= $form->field($model, 'secondary_phone')->textInput(['placeholder' => 'هاتف مساءي'])->label(false) ?>



    <?= $form->field($model, 'app_service')->dropDownList([ 'yes' => 'Yes', 'no' => 'No', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'logitude')->textInput() ?>

    <?= $form->field($model, 'latitude')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
