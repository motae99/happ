<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin([   
            'id' => 'category-update-form',
            'options'=>['method' => 'post'],
            'action' => Url::to(['category/update', 'id'=> $model->id]),
            
        ]); 
    ?>

    <?= $form->field($model, 'name')->textInput(['placeholder'=>'Category Name', 'maxlength' => true])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'update'), ['class' => 'btn btn-block btn-flat btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
