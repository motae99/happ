<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $insu app\models\PharInsu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lab-exam-form">

    <?php $form = ActiveForm::begin([ 
            'id' => 'lab-exam',
            'options'=>['method' => 'post'],
            'action' => Url::to(['exam', 'id'=> $model->id]),
        ]); 
    ?>
    <?= $form->field($exam, 'name')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'الأسم')])->label(false) ?>

    <?= $form->field($exam, 'description')->textarea(['rows' => 1, 'placeholder' => Yii::t('app', 'الوصف')])->label(false) ?>

    <?= $form->field($exam, 'price')->textarea(['maxlength' => true, 'placeholder' => Yii::t('app', 'السعر')])->label(false) ?>
    <?= $form->field($exam, 'resault')->textarea(['maxlength' => true, 'placeholder' => Yii::t('app', 'تسليم النتيجة')])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?> 