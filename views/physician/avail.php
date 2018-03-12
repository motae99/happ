<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Clinic;
use yii\helpers\ArrayHelper;
use kartik\time\TimePicker;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\select2\Select2;
use app\models\Insurance;
use wbraganca\dynamicform\DynamicFormWidget;



/* @var $this yii\web\View */
/* @var $model app\models\Physician */

?>

<?php $fetch = Url::to(['physician/clinic']);?>
<div class="availability-form">
    <?php $form = ActiveForm::begin([   
            'id' => 'available-create-form',
            'options'=>['method' => 'post'],
            'action' => Url::to(['physician/availability', 'id'=> $model->id]),
            
        ]); ?>

    <?= $form->field($available, 'clinic_id')->widget(Select2::classname(), 
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
                                    // var index  = this.attr("id").replace(/[^0-9.]/g, "");  
                                    // var inventory = $("#invoiceproduct-" + index + "-inventory_id").val(); 
                                    return {q:params.term, inventory_id:inventory }; 
                                }'),
                          ],
                          'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                          'templateResult' => new JsExpression('function(name) { return name.text; }'),
                          'templateSelection' => new JsExpression('function (name) { return name.text; }'),
                          'allowClear' => true,
                        ],
                        ])->label(false);
      
                        // ])->label(false);
                        // ->dropDownList(
                        //     ArrayHelper::map(Clinic::find()->all(), 'id', 'name'),
                        //     [
                        //         'prompt'=>Yii::t('app', 'Health Center'),
                        //     ])->label(false);  
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
                <th>Insurances</th>
                <th>patient_payment</th>
                <th>insurance_refund</th>
                <th>contract_expiry</th>            
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
                <td>
                    <?= $form->field($ins, "[{$i}]contract_expiry")->label(false)->textInput(['maxlength' => true]) ?>
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