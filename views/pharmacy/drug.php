<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Insurance;


/* @var $this yii\web\View */
/* @var $insu app\models\PharInsu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="phar-insu-form">

    <?php $form = ActiveForm::begin([ 
            'id' => 'insu',
            'options'=>['method' => 'post'],
            'action' => Url::to(['drug', 'id'=> $model->id]),
        ]); 
    ?>
    <?= $form->field($drug, 'product_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($drug, 'description')->textarea(['rows' => 1]) ?>

    <?= $form->field($drug, 'no')->textarea() ?>
    <?= $form->field($drug, 'price')->textarea() ?>
    <?= $form->field($drug, 'quantity')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?> 