<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ambulance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ambulance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder'=> "أسم الشركة"])->label(false) ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 2, 'placeholder'=> "العنوان"])->label(false) ?>

    <?= $form->field($model, 'working_hourse')->textarea(['rows' => 1, 'placeholder'=> "ساعات العمل"])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
