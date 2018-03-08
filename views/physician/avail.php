<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Clinic;
use yii\helpers\ArrayHelper;
use kartik\time\TimePicker;
use yii\helpers\Url;
use kartik\select2\Select2;



/* @var $this yii\web\View */
/* @var $model app\models\Physician */

?>

<div class="availability-form">
    <?php $form = ActiveForm::begin([   
            'id' => 'available-create-form',
            'options'=>['method' => 'post'],
            'action' => Url::to(['physician/availability', 'id'=> $model->id]),
            
        ]); ?>

    <?= $form->field($available, 'clinic_id')->dropDownList(
                        ArrayHelper::map(Clinic::find()->all(), 'id', 'name'),
                        [
                            'prompt'=>Yii::t('app', 'Health Center'),
                        ])->label(false);  
    ?>


    <?= $form->field($available, "date")->widget(Select2::classname(), 
        [
            'data' =>[6 => Yii::t('app', 'Saterday') , 0 => Yii::t('app', 'Sunday'), 1 => Yii::t('app', 'Monday'), 2 => Yii::t('app', 'Tuseday'), 3 => Yii::t('app', 'Wensday'), 4 => Yii::t('app', 'Thursday'), 5 => Yii::t('app', 'Friday')],
            // 'language' => 'de',
            'options' => ['multiple' => true, 'placeholder' => 'Select working Days ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],

        ])->label(false);
        ?>

    <?= $form->field($available, 'from_time')->widget(TimePicker::classname(), []);?>
    
    <?= $form->field($available, 'to_time')->widget(TimePicker::classname(), []);?>

    <?= $form->field($available, 'appointment_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($available, 'revisiting_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($available, 'max')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
