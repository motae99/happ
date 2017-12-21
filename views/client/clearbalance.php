<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $payment app\models\Payments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="opening-balance">

    <?php $form = ActiveForm::begin(
        [   
            'id' => 'opening',
            'options'=>['method' => 'post'],
            'action' => Url::to(['client/clear', 'id' => $model->id]),
            
        ]); 
    ?>

    <?= $form->field($model, 'clear', [
                'addon' => [
                    'append' => [
                        'content' => Html::submitButton('Pay', ['class'=>'btn btn-primary']),
                        'asButton' => true
                    ]
                ]
            ])->textInput()->label(false);
    ?>

    <?php ActiveForm::end(); ?>

</div> 