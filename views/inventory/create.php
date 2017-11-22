<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Inventory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-form">

    <?php $form = ActiveForm::begin(
        [   
            'id' => 'inventory-create-form',
            'options'=>['method' => 'post'],
            'action' => Url::to(['inventory/create']),
            
        ]); 
    ?>

    <?= $form->field($model, 'name')->textInput(['placeholder'=>'Inventory Name', 'maxlength' => true])->label(false) ?>
    
    <?= $form->field($model, 'alias')->textInput(['placeholder'=>'Short Name', 'maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'address')->textarea(['placeholder'=>'Address', 'rows' => 6])->label(false) ?>

    <?= $form->field($model, 'phone_no')->textInput(['placeholder'=>'Phone No', 'maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'color_class')->textInput(['placeholder'=>'Select Color', 'maxlength' => true])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-flat btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
