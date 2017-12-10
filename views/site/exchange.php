<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;

?>


    <?php $form = ActiveForm::begin([   
            'id' => 'dollar-exchange-form',
            'options'=>['method' => 'post'],
            'action' => Url::to(['site/dollar']),
            
        ]); 
    ?>

    <?= $form->field($model, 'name', [
                'addon' => [
                    'append' => [
                        'content' => Html::submitButton('Go', ['class'=>'btn btn-primary']),
                        'asButton' => true
                    ]
                ]
            ])->textInput();
    ?>

    <?php ActiveForm::end(); ?>

