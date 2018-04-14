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
            'action' => Url::to(['insu', 'id'=> $model->id]),
        ]); 
    ?>
    <?= $form->field($insu, 'insurance_id')->dropDownList(
                            ArrayHelper::map(Insurance::find()->all(), 'id', 'name'),
                            [
                                'prompt'=>Yii::t('app', 'اسم جهة التأمين'),
                            ])->label(false) ?>

    <?= $form->field($insu, 'discount')->textInput(['placeholder' => "نسبة التخفيض" ,'type' => 'number' ,'maxlength' => true])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
 