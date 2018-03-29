<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Clinic;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\select2\Select2;
use app\models\Insurance;
use wbraganca\dynamicform\DynamicFormWidget;



/* @var $this yii\web\View */
/* @var $model app\models\Physician */

?>
<!-- <div class=" eArLangCss col-lg-12" -->

<?php $fetch = Url::to(['physician/clinic']);?>

<div class="availability-form">
    <?php $form = ActiveForm::begin([   
            'id' => 'available-create-form',
            'options'=>['method' => 'post'],
            'action' => Url::to(['physician/availability', 'id'=> $model->id]),
            
        ]); ?>
<div class="col-lg-12">
    <div class="row">
    <div class=" eArLangCss col-lg-6">
        <?= $form->field($available, 'clinic_id')
                // ->dropDownList(
                //     ArrayHelper::map(Clinic::find()->all(), 'id', 'name'),
                //     [
                //         'prompt'=>Yii::t('app', 'Health Center'),
                //     ])->label(false);  
                ->widget(Select2::classname(), 
                    [
                        'options' => [
                            'placeholder' => Yii::t('app', 'المؤسسة الطبية والصحية'),
                        ],
                        'pluginOptions' => [
                          'minimumInputLength' => 2,
                          'ajax' => [
                              'url' => $fetch,
                              'dataType' => 'json',
                              'data' => new JsExpression('function(params) {
                                    return {q:params.term }; 
                                }'),
                          ],
                          'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                          'templateResult' => new JsExpression('function(name) { return name.text; }'),
                          'templateSelection' => new JsExpression('function (name) { return name.text; }'),
                          'allowClear' => true,
                        ],
                        ])
                ->label(false);
      
        ?>

    </div>
    <div class=" eArLangCss col-lg-2">
        <?= $form->field($available, 'appointment_fee')->textInput(['maxlength' => true, 'placeholder' => 'رسوم الحجز'])->label(false); ?>
    </div>
    <div class=" eArLangCss col-lg-2">
        <?= $form->field($available, 'revisiting_fee')->textInput(['maxlength' => true, 'placeholder' => 'رسوم المتابعة'])->label(false); ?>
    </div>
    <div class=" eArLangCss col-lg-2">
        <?= $form->field($available, 'max')->textInput(['placeholder' => 'عدد المقابﻻت'])->label(false); ?>
    </div>
    </div>

    <div class="row">
        <div class=" eArLangCss col-lg-3">
            <?= $form->field($available, "date")->widget(Select2::classname(), 
                [
                    'data' =>[6 => Yii::t('app', 'السبت') , 0 => Yii::t('app', 'الأحد'), 1 => Yii::t('app', 'الأثنثن'), 2 => Yii::t('app', 'الثﻻثاء'), 3 => Yii::t('app', 'الأربعاء'), 4 => Yii::t('app', 'الخميس'), 5 => Yii::t('app', 'الجمعة')],
                    'language' => 'ar',
                    'options' => ['multiple' => true, 'placeholder' => 'أيام العمل ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],

                ])->label(false);
            ?>
        </div>
    
        <div class=" eArLangCss col-lg-3">
            <?= $form->field($available, 'from_time') ->textInput(
                                [   
                                    'class' => 'design',
                                    'readonly' => True,
                                    'value'=> $start
                                ])
                            ->label(false);
            ?>

        </div>
        <div class=" eArLangCss col-lg-3">
            <?= $form->field($available, 'to_time') ->textInput(
                                [   
                                    'class' => 'design',
                                    'readonly' => True,
                                    'value'=> $end
                                ])
                            ->label(false);
            ?>
        </div>
        <div class=" eArLangCss col-lg-3">
            <?= $form->field($available, 'duration') ->textInput(
                                [   
                                    'placeholder' => 'فترة المقابلة',
                                ])
                            ->label(false);
            ?>
        </div>

    </div>

    

    <?php DynamicFormWidget::begin([

        'widgetContainer' => 'dynamicform_inner',

        'widgetBody' => '.container-insurances',

        'widgetItem' => '.item',

        'limit' => 20,

        'min' => 0,

        'insertButton' => '.add-item',

        'deleteButton' => '.remove-item',

        'model' => $insurance[0],

        'formId' => 'available-create-form',

        'formFields' => [

            'id',
            'insurance_id',
            'patient_payment',
            'insurance_refund',
            'contract_expiry',
        ],

    ]); ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>مقدم الخدمة</th>
                <th>رسوم المريض</th>
                <th>مستحق الطبيب</th>
                <th class="text-center">
                    <button type="button" class="add-item btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
                </th>
            </tr>
        </thead>
        <tbody class="container-insurances">
        <?php foreach ($insurance as $i => $ins): ?>
            <tr class="item">
                <td class="vcenter">
                    <?php
                        if (! $ins->isNewRecord) {
                            echo Html::activeHiddenInput($ins, "[{$i}]id");
                        }
                    ?>
                    <?php echo $form->field($ins, "[{$i}]insurance_id")->label(false)->dropDownList(
                            ArrayHelper::map(Insurance::find()->all(), 'id', 'name'),
                            [
                                // 'prompt'=>Yii::t('app', 'Insurance Provider'),
                            ]);  ?>
                </td>
                <td>
                    <?= $form->field($ins, "[{$i}]patient_payment")->textInput(['maxlength' => true])->label(false) ?>
                </td>
                <td>
                    <?= $form->field($ins, "[{$i}]insurance_refund")->label(false)->textInput(['maxlength' => true]) ?>
                </td>
               
                <td class="text-center vcenter" style="width: 90px;">

                    <button type="button" class="remove-item btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>

                </td>

            </tr>

         <?php endforeach; ?>

        </tbody>

    </table>

    <?php DynamicFormWidget::end(); ?>


    <?php /* echo $this->render('_insurance', [
                        'form' => $form,
                        'insurance' => $insurance,
                    ])*/ ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>