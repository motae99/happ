<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2; 
use app\models\Pharmacy;
use app\models\Insurance;


/* @var $this yii\web\View */
/* @var $model app\models\PharInsu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="phar-insu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'phar_id')->label(false)->dropDownList(
                            ArrayHelper::map(Pharmacy::find()->all(), 'id', 'name'),
                            [
                                'prompt'=>Yii::t('app', 'اسم الصيدلية'),
                            ]); ?>

    <?= $form->field($model, 'insurance_id')->dropDownList(
                            ArrayHelper::map(Insurance::find()->all(), 'id', 'name'),
                            [
                                'prompt'=>Yii::t('app', 'اسم جهة التأمين'),
                            ]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
