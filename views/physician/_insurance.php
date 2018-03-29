<?php


use yii\helpers\Html;
use app\models\Insurance;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;

?>


<?php DynamicFormWidget::begin([

    'widgetContainer' => 'dynamicform_inner',

    'widgetBody' => '.container-insurances',

    'widgetItem' => '.insurance-item',

    'limit' => 20,

    'min' => 0,

    'insertButton' => '.add-insurance',

    'deleteButton' => '.remove-insurance',

    'model' => $insurance[0],

    'formId' => 'dynamic-form',

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
            <th class="text-center">
                <button type="button" class="add-insurance btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
            </th>
        </tr>
    </thead>
    <tbody class="container-insurances">
    <?php foreach ($insurance as $i => $ins): ?>
        <tr class="insurance-item">
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

                <button type="button" class="remove-insruance btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>

            </td>

        </tr>

     <?php endforeach; ?>

    </tbody>

</table>

<?php DynamicFormWidget::end(); ?>