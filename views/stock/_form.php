<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Pharmacy;
use yii\helpers\Url;
use app\models\DrugSupplier;
use app\models\Drugs;
use wbraganca\dynamicform\DynamicFormWidget;




/* @var $this yii\web\View */
/* @var $model app\models\Stock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-form">

    <?php $form = ActiveForm::begin([ 
        'id' => 'stock-form',
        'options'=>['method' => 'post'],
        'action' => Url::to(['stock/add']),


    ]); ?>

    <?php DynamicFormWidget::begin([

        'widgetContainer' => 'dynamicform_inner',

        'widgetBody' => '.stock-table',

        'widgetItem' => '.item',

        'limit' => 20,

        'min' => 1,

        'insertButton' => '.add-item',

        'deleteButton' => '.remove-item',

        'model' => $model[0],

        'formId' => 'stock-form',

        'formFields' => [

            'phar_id',
            'sup_id',
            'drug_id',
            'quantity',
            'buying_price',
            'selling_price',
        ],

    ]); ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>الصيدلية</th>
                <th>المورد</th>
                <th>الدواء</th>
                <th>الكمية</th>
                <th>سعر الشراء</th>            
                <th>سعر البيع</th>            
                <th></th>            
                <th class="text-center">
                    <button type="button" class="add-item btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
                </th>
            </tr>
        </thead>
        <tbody class="stock-table">
        <?php foreach ($model as $i => $m): ?>
            <tr class="item">
                <td class="vcenter">

    <?= $form->field($m, 'phar_id')->label(false)->dropDownList(
                            ArrayHelper::map(Pharmacy::find()->all(), 'id', 'name'),
                            [
                                'prompt'=>Yii::t('app', 'اسم الصيدلية'),
                            ]); ?>
                </td>
                <td>
    <?= $form->field($m, 'sup_id')->label(false)->dropDownList(
                            ArrayHelper::map(DrugSupplier::find()->all(), 'id', 'name'),
                            [
                                'prompt'=>Yii::t('app', 'اسم المورد'),
                            ]); ?>

                </td>

                <td>
    <?= $form->field($m, 'drug_id')->label(false)->dropDownList(
                            ArrayHelper::map(Drugs::find()->all(), 'id', 'product_name'),
                            [
                                'prompt'=>Yii::t('app', 'اسم الدواء'),
                            ]); ?>
                </td>
                <td>

    <?= $form->field($m, 'quantity')->textInput()->label(false) ?>
                </td>
                <td>
    <?= $form->field($m, 'buying_price')->textInput(['maxlength' => true])->label(false) ?>
                </td>
                <td>

    <?= $form->field($m, 'selling_price')->textInput(['maxlength' => true])->label(false) ?>
                </td>
                <td class="text-center vcenter" style="width: 90px;">

                    <button type="button" class="remove-item btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>

                </td>
            </tr>

         <?php endforeach; ?>

        </tbody>

    </table>

    <?php DynamicFormWidget::end(); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
