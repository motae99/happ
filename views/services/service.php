<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\services */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="services-form">

    <?php $form = ActiveForm::begin([ 
            'id' => 'services',
            'options'=>['method' => 'post'],
            'action' => Url::to(['service']),
        ]); 
    ?>


    <?= $form->field($service, 'name')->textInput([
                            'placeholder'=>Yii::t('app', 'أسم الخدمة'),
                        ])->label(false);  
    ?>

           


    <?= $form->field($service, 'description')->textInput([
                            'placeholder'=>Yii::t('app', 'الوصف'),
                        ])->label(false);  
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
