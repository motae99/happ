<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin([   
            'id' => 'product-create-form',
            'options'=>['method' => 'post'],
            'action' => Url::to(['product/create']),
            
        ]); 
    ?>

    <?= $form->field($model, 'category_id')->textInput() ?>

    <?= $form->field($model, 'no')->textInput(['placeholder'=>'Product No', 'maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'product_name')->textInput(['placeholder'=>'Product Name', 'maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'description')->textInput(['placeholder'=>'Product Description', 'maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'buying_price')->textInput(['placeholder'=>'buying_price', 'maxlength' => true])->label(false) ?>
    
    <?= $form->field($model, 'selling_price')->textInput(['placeholder'=>'selling_price', 'maxlength' => true])->label(false) ?>
    
    <?= $form->field($model, 'minimum')->textInput(['placeholder'=>'minimum', 'maxlength' => true])->label(false) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-flat btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
