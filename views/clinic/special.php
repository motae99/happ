<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Physician;


/* @var $this yii\web\View */
/* @var $model app\models\Specialization */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="specialization-form">

    <?php $form = ActiveForm::begin([ 
            'id' => 'specialization',
            'options'=>['method' => 'post'],
            'action' => Url::to(['special', 'id'=> $model->id]),
        ]); 
    ?>


    <?= $form->field($special, 'physician_id')->dropDownList(
                        ArrayHelper::map(Physician::find()->all(), 'id', 'name'),
                        [
                            'prompt'=>Yii::t('app', 'أسم الطبيب'),
                        ])->label(false);  
    ?>

           


    <?= $form->field($special, 'specialty')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
