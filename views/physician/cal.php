<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\time\TimePicker; 

/* @var $this yii\web\View */
/* @var $model app\models\Availability */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calender-form">

    <?php $form = ActiveForm::begin(); ?>

<div class="row">
<div class="col-lg-12">

<div class="col-lg-4">
  <?= $form->field($model, 'date')->widget(DatePicker::classname(), 
                        [
                            'type' => DatePicker::TYPE_INPUT,
                            'options' => ['placeholder' => Yii::t('app', 'Date')],
                            'pluginOptions' => [
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true
                            ]    
                        ])
                    ->label(false); 
    ?>
</div>
<div class="col-lg-4">
    <?= $form->field($model, 'start_time')->widget(TimePicker::classname(), [])->label(false);?>

</div>
<div class="col-lg-4">
    <?= $form->field($model, 'end_time')->widget(TimePicker::classname(), [])->label(false);?>

</div>
<div class="col-lg-6">
    <?= $form->field($model, 'status')
        ->dropDownList(['available' => Yii::t('app', 'متاح'), 'canceled' => Yii::t('app', 'الغاء')
                    ])->label(false);
    ?>

</div>
<div class="col-lg-6">
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>

</div>

</div>    


</div>




    <?php ActiveForm::end(); ?>

</div>
