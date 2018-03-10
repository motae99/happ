<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\time\TimePicker; 


/* @var $this yii\web\View */
/* @var $model app\models\Clinic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clinic-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-lg-6">
    <?= $form->field($model, 'type')->dropDownList(['مستشفى خاص' => Yii::t('app', 'مستشفى خاص'), 'مستشفى حكومي' => Yii::t('app', 'مستشفى حكومي'), 'مستوصف' => Yii::t('app', 'مستوصف'), 'عيادة' => Yii::t('app', 'عيادة'), 'مركز صحي' => Yii::t('app', 'مركز صحي')], ['prompt' => Yii::t('app', 'Select Type ')])->label(false); ?>
    </div>
    <div class="col-lg-6">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Name')])->label(false) ?>
    </div>

</div>
   

    <?= $form->field($model, 'state')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'State')])->label(false) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'City')])->label(false) ?>
    
    <?= $form->field($model, 'manager')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'المدير الطبي')])->label(false) ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 2, 'placeholder' => Yii::t('app', 'Address')])->label(false) ?>

    <?= $form->field($model, 'primary_contact')->textInput([ 'placeholder' => Yii::t('app', 'Primary Contacy')])->label(false) ?>

    <?= $form->field($model, 'secondary_contact')->textInput(['placeholder'=> Yii::t('app', 'Secondary Contacy')])->label(false) ?>

    <?= $form->field($model, "working_days")->widget(Select2::classname(), 
        [
            'data' =>['sat' => Yii::t('app', 'Saterday') ,'sun' => Yii::t('app', 'Sunday'), 'mon' => Yii::t('app', 'Monday'), 'tue' => Yii::t('app', 'Tuseday'), 'wen' => Yii::t('app', 'Wensday'), 'thu' => Yii::t('app', 'Thursday'), 'fri' => Yii::t('app', 'Friday')],
            // 'language' => 'de',
            'options' => ['multiple' => true, 'placeholder' => 'Select working Days ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],

        ])->label(false);
    ?>

    
    <?= $form->field($model, 'start')->widget(TimePicker::classname(), [])->label(false);?>
    <?= $form->field($model, 'end')->widget(TimePicker::classname(), [])->label(false);?>



    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
