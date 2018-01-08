<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Stock;
use app\models\Inventory;
use app\models\Client;
use kartik\select2\Select2;
use yii\web\JsExpression;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Invoices */


?>
<?php 
    $fetch = Url::to(['product/inproduct']);
    $details = Url::to(['product/prodetail']);
    
?>

<script>

function pro(item){
    var index  = item.attr("id").replace(/[^0-9.]/g, ""); 
    var product_id = $('#invoiceproduct-' + index + '-product_id').val();
    var inventory_id = $('#invoiceproduct-' + index + '-inventory_id').val();
    product_id = product_id == "" ? 0 : Number(product_id.split(",").join(""));
    $.ajax({
         url: "<?=$details?>?product_id=" + product_id + "&inventory_id=" + inventory_id,
         dataType: 'json',
         method: 'GET',
         data: product_id,
         success: function (data, textStatus, jqXHR) {
            $('#invoiceproduct-' + index + '-selling_rate').val(data.selling_price) ;
            $('#invoiceproduct-' + index + '-available').val(data.quantity) ;
            $('#invoiceproduct-' + index + '-discount').prop('max', data.selling_price);
            $('#invoiceproduct-' + index + '-quantity').prop('max', data.quantity);
            $('#invoiceproduct-' + index + '-quantity').prop('readonly', false);
            $('#invoiceproduct-' + index + '-selling_rate').val(data.selling_price);
            $('#invoiceproduct-' + index + '-selling_rate').prop('min', data.selling_price);
            $('#invoiceproduct-' + index + '-selling_rate').prop('readonly', false);
            $('#invoiceproduct-' + index + '-selling_rate').prop('readonly', false);
         },
         //  beforeSend: function (xhr) {
         //      alert('loading!');
         // },
          error: function (jqXHR, textStatus, errorThrown) {
            $('#invoiceproduct-' + index + '-selling_rate').val('') ;
            $('#invoiceproduct-' + index + '-quantity').val('') ;
            $('#invoiceproduct-' + index + '-buying_rate').val('') ;
            $('#invoiceproduct-' + index + '-quantity').prop('readonly', true);
            $('#invoiceproduct-' + index + '-selling_rate').prop('readonly', true);
              
          }
    });
    calculateTotal();

}


function check(item) {
    var index  = item.attr("id").replace(/[^0-9.]/g, "");  
    if ($('#invoices-client_id').val() > 1) {
        $('#invoiceproduct-' + index + '-discount').prop('readonly', false);
    }
    var quantity = $('#invoiceproduct-' + index + '-quantity').val();
    var discount = $('#invoiceproduct-' + index + '-discount').val();
    quantity = quantity == "" ? 0 : Number(quantity.split(",").join(""));
    
    var selling_rate = $('#invoiceproduct-' + index + '-selling_rate').val();
    selling_rate = selling_rate == "" ? 0 : Number(selling_rate.split(",").join(""));

    var max = $('#invoiceproduct-' + index + '-quantity').attr('max');
    var minPrice = $('#invoiceproduct-' + index + '-selling_rate').attr('min');
    // var discountMax = $('#invoiceproduct-' + index + '-discount').attr('max');
    if(quantity > max ) {
        alert('you dont have this much! avaiablabe is:' + max);  
    }else if (selling_rate < minPrice) {
        alert('you cant sell for less than :' + minPrice + 'you may use discounts'); 
    }
    // else if (discount > discountMax) {
    //     alert('you cant do this discount :' + discountMax); 
    // }
    else{
        $('#invoiceproduct-' + index + '-buying_rate').val(selling_rate * quantity - discount);  

    }
    calculateTotal();
}
 
function calculateTotal(){
    subTotal = 0 ;
    $('.totalLinePrice').each(function(){
        if($(this).val() != '' )subTotal += parseFloat( $(this).val() );
    });
    $('#invoices-amount').val( subTotal );
    $('#invoices-pay').prop('max', subTotal);
    $('#invoices-pay').val( subTotal );
    calculateAmountDue();
}

function calculateAmountDue(){
    amountPaid = $('#invoices-pay').val();
    total = $('#invoices-amount').val();
    if(amountPaid != total ){
        amountDue = parseFloat(total) - parseFloat( amountPaid );
        $('#info').show();
        $('#invoices-amountdue').val(amountDue);

    }else{
         $('#info').hide();
    }


}

function cash(){
    if ($('#invoices-client_id').val() == 1) {
        $('#invoices-pay').prop('readonly', true);
    }else{
        $('#invoices-pay').prop('readonly', false);
    }
}


</script>

<div class="invoices-form" style="margin-top: 30px;">

    <?php $form = ActiveForm::begin([ 
            'id'=>"dynamic-form",
            'options'=>['method' => 'post'],
            'action' => Url::to(['invoices/new'])
            ]);  
    ?>
         <?= $form->field($model, 'client_id')
                ->dropDownList(ArrayHelper::map(Client::find()->all(), 'id', 'client_name'),
                [
                    'prompt'=>Yii::t('invo', 'Cient'), 
                    'onchange'=> 'cash()',

                ])->label(false);  
        ?>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 100, // the maximum times, an element can be added (default 999)
        // 'min' => 0, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsItem[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'product_id',
            'quantity',
        ],
    ]); ?>

    <table class="table table-borderd table-responsive container-items">
        <tr class="bg-aqua">
            <th style="width: 20%;"><?=Yii::t('invo', 'Inventory')?></th>
            <th style="width: 20%;"><?=Yii::t('invo', 'Item')?></th>
            <th style="width: 11%;"><?=Yii::t('invo', 'Available')?></th>
            <th style="width: 11%;"><?=Yii::t('invo', 'Quantity')?></th>
            <th style="width: 13%;"><?=Yii::t('invo', 'Price')?></th>
            <th style="width: 8%;"><?=Yii::t('invo', 'Discount')?></th>
            <th style="width: 13%;"><?=Yii::t('invo', 'LineTotal')?></th>
            <th style="width: 4%;">
                <button type="button" class="add-item btn btn-xs"><i class="fa fa-plus"></i></button>
            </th>
        </tr>
        <?php foreach ($modelsItem as $i => $modelItem): ?>
        <tr class="item">
            <?php
                // necessary for update action.
                if (! $modelItem->isNewRecord) {
                    echo Html::activeHiddenInput($modelItem, "[{$i}]id");
                }
            ?>
            <td style="width: 20%;">
                <?= $form->field($modelItem, "[{$i}]inventory_id")->dropDownList(
                        ArrayHelper::map(Inventory::find()->all(), 'id', 'name'),
                        [
                            'prompt'=>Yii::t('invo', 'Inventory'),

                        ])->label(false); 
                ?>
            </td>
            <td style="width: 20%;">
                <?= $form->field($modelItem, "[{$i}]product_id")->widget(Select2::classname(), 
                    [
                        'options' => [
                            'placeholder' => Yii::t('invo', 'Item'),
                            'onchange' => 'pro($(this))',
                        ],
                        'pluginOptions' => [
                          'minimumInputLength' => 2,
                          'ajax' => [
                              'url' => $fetch,
                              'dataType' => 'json',
                              'data' => new JsExpression('function(params) {
                                    var index  = this.attr("id").replace(/[^0-9.]/g, "");  
                                    var inventory = $("#invoiceproduct-" + index + "-inventory_id").val(); 
                                    return {q:params.term, inventory_id:inventory }; 
                                }'),
                          ],
                          'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                          'templateResult' => new JsExpression('function(name) { return name.text; }'),
                          'templateSelection' => new JsExpression('function (name) { return name.text; }'),
                          'allowClear' => true,
                        ],
      
                    ])->label(false);
                ?>
            </td>
            <td style="width: 11%;">
                <?= $form->field($modelItem, "[{$i}]available")
                    ->textInput(
                        [
                            'readonly' => true, 
                            'placeholder'=>Yii::t('invo', 'Available'),
                        ])
                    ->label(false) 
                ?>
            </td>
            <td style="width: 11%;">
                <?= $form->field($modelItem, "[{$i}]quantity")
                    ->textInput(
                        [
                            'type' => 'number', 
                            'onchange' => 'check($(this))',
                            'readonly' => true,
                            'min' => 1,
                            'placeholder'=>Yii::t('invo', 'Quantity'),
                        ])
                    ->label(false) 
                ?>
            </td>
            <td style="width: 13%;">
                <?= $form->field($modelItem, "[{$i}]selling_rate")
                    ->textInput(
                        [
                            'type' => 'number',
                            'placeholder'=>Yii::t('invo', 'Price'),
                            'readonly' => true,
                            'onchange' => 'check($(this))',
                        ])
                    ->label(false) 
                ?>
            </td>
            <td style="width: 8%;">
                <?= $form->field($modelItem, "[{$i}]discount")
                    ->textInput(
                        [
                            'type' => 'number',
                            'placeholder'=>Yii::t('invo', 'Discount'),
                            'readonly' => true,
                            'min' => 1,
                            'onchange' => 'check($(this))',
                        ])
                    ->label(false) 
                ?>
            </td>
            <td style="width: 13%;">
                <?= $form->field($modelItem, "[{$i}]buying_rate")
                    ->textInput(
                        [   
                            'class' => 'form-control totalLinePrice',
                            'type' => 'number', 
                            'disabled' => True,
                            'onchange' => 'calculateTotal()', 
                            'placeholder'=>Yii::t('invo', 'LineTotal')
                        ])
                    ->label(false)
                ?>
            </td>
            <td style="width: 4%;">
                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
            </td>
        <?php endforeach; ?>
    </table>
    <hr style=" border-bottom: 1px solid #000;">

    <?php DynamicFormWidget::end(); ?>
    <div class="col-sm-5 eArLangCss">
        <?= $form->field($model, 'amount')
            ->textInput(
                [
                    'placeholder'=>Yii::t('invo', 'Total'), 
                    // 'onchange'=> 'calculateAmountDue()',
                    'type' => 'number',
                    'readonly' => true,
                ])->label(false) 
        ?>
    </div>
    <div class="col-sm-5 eArLangCss">
        <?= $form->field($model, 'pay')
            ->textInput(
            [
                'placeholder'=>Yii::t('invo', 'Pay'),
                'type' => 'number',
                'onchange'=> 'calculateAmountDue()',
            ])->label(false) 
        ?> 
    </div>
    <div class="col-sm-2 eArLangCss" id="info" >
        <?= $form->field($model, Yii::t('invo', 'amountDue'))
                    ->textInput(
                    [
                        'placeholder'=>Yii::t('invo', 'amountDue'),
                        'type' => 'number',
                        'disabled' => True,
                    ]

            )->label(false);  
        ?>
        <hr style=" border-bottom: 4px solid red;">
    </div>
        
    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('invo', 'Create'), ['class' => " btn bg-aqua btn-flat btn-block"]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>


<?php 
$script = <<< JS
$(document).ready(function () {
    $("#info").hide();
});

$(".dynamicform_wrapper").on("afterDelete", function(e) {
    calculateTotal();
});

JS;
$this->registerJs($script);
?>  
