<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Stock;
use app\models\Client;
use kartik\select2\Select2;
use yii\web\JsExpression;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Invoices */

$this->title = Yii::t('app', 'Create Invoices');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Invoices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php 
    // $product_details = \yii\helpers\Url::to(['details']);
    
?>

<script>


<?php $details = Url::to(['invoices/details']);?>
function pro(item){
    var index  = item.attr("id").replace(/[^0-9.]/g, ""); 
    var product_id = $('#invoiceproduct-' + index + '-product_id').val();
    var inventory_id = "<?= $inventory->id; ?>";
    product_id = product_id == "" ? 0 : Number(product_id.split(",").join(""));
    $.ajax({
         url: "<?=$details?>?product_id=" + product_id + '&inventory_id=' + inventory_id,
         dataType: 'json',
         method: 'GET',
         data: product_id,
         success: function (data, textStatus, jqXHR) {
            $('#invoiceproduct-' + index + '-selling_rate').val(data.selling_price) ;
            $('#invoiceproduct-' + index + '-quantity').prop('min', 1);
            $('#invoiceproduct-' + index + '-quantity').prop('max', data.quantity);
            $('#invoiceproduct-' + index + '-quantity').prop('readonly', false);
         },
         //  beforeSend: function (xhr) {
         //      alert('loading!');
         // },
          error: function (jqXHR, textStatus, errorThrown) {
            $('#invoiceproduct-' + index + '-selling_rate').val('') ;
            $('#invoiceproduct-' + index + '-quantity').val('') ;
            $('#invoiceproduct-' + index + '-buying_rate').val('') ;
            $('#invoiceproduct-' + index + '-quantity').prop('readonly', true);
            calculateTotal();
              
          }
    });

}


function check(item) {
    var index  = item.attr("id").replace(/[^0-9.]/g, "");  
    
    var quantity = $('#invoiceproduct-' + index + '-quantity').val();
    quantity = quantity == "" ? 0 : Number(quantity.split(",").join(""));
    
    var selling_rate = $('#invoiceproduct-' + index + '-selling_rate').val();
    selling_rate = selling_rate == "" ? 0 : Number(selling_rate.split(",").join(""));

    var max = $('#invoiceproduct-' + index + '-quantity').attr('max');
    if(quantity > max) {
        $('div.field-invoiceproduct-' + index + '-quantity').addClass('has-error');
        $('#invoiceproduct-' + index + '-quantity').prop('aria-invalid', 'true');
        // $('input #invoiceproduct-' + index + '-quantity').attr('aria-invalid', 'true');
        $('#invoiceproduct-' + index + '-quantity').val(max);
        // $('#invoiceproduct-' + index + '-buying_rate').val('Stock is less');
        alert('you dont have this much! avaiablabe is:' + max);  
    }else{
        $('#invoiceproduct-' + index + '-buying_rate').val(selling_rate * quantity);  

    }
    calculateTotal();
}

// function 

//total price calculation 
function calculateTotal(){
    subTotal = 0 ;
    $('.totalLinePrice').each(function(){
        if($(this).val() != '' )subTotal += parseFloat( $(this).val() );
    });
    $('#invoices-amount').val( subTotal );
    $('#invoices-pay').prop('max', subTotal);
    $('#invoices-pay').val( subTotal );
    
    // calculateAmountDue();

    // $('#invoices-amount').val( subTotal.toFixed(2) );
    // tax = $('#tax').val();
    // if(tax != '' && typeof(tax) != "undefined" ){
    //     taxAmount = subTotal * ( parseFloat(tax) /100 );
    //     $('#taxAmount').val(taxAmount.toFixed(2));
    //     total = subTotal + taxAmount;
    // }else{
    //     $('#taxAmount').val(0);
    //     total = subTotal;
    // }
    // $('#totalAftertax').val( total.toFixed(2) );
}



//due amount calculation
function calculateAmountDue(){
    amountPaid = $('#invoices-pay').val();
    total = $('#invoices-amount').val();
    if(amountPaid < total ){
        amountDue = parseFloat(total) - parseFloat( amountPaid );
        $('#info').show();
        $('#invoices-amountDue').val(amountDue);

    }
    else{
         $('#info').hide();
    }
}

</script>

<div class="invoices-form" style="margin-top: 30px;">

    <?php $form = ActiveForm::begin([ 
            'id'=>"dynamic-form",
            'options'=>['method' => 'post'],
            'action' => Url::to(['invoices/create', 'id' => $inventory->id])
            ]);  
    ?>
    <div class="col-sm-8" style="min-height: 400px; border-right: 2px solid #ecf0f5;">
        <h1 style="text-align: center;  font-size: 40px; font-family: e; font-weight: bold;">
             Invoice
        </h1>
        <span class="text-bold"> #</span>
        <span class="pull-right text-bold"> </span>
        <hr style="margin-top: 0px; margin-bottom: 0px; border-top: 2px solid #3434" >
        
    </div>
    <div class="col-sm-4" style="min-height: 400px; padding-left: 0; padding-right: 0;">
        <div class="col-sm-12" style="min-height: 180px;">
            <?= $inventory->name;?>
            <?= $inventory->address;?>

        </div>
        <div class="col-sm-12" style="min-height: 180px; border-top:2px solid #ecf0f5">
            <?= $form->field($model, 'client_id')
                ->dropDownList(ArrayHelper::map(Client::find()->all(), 'id', 'client_name'),
                [
                    'prompt'=>'Client Name', 
                    // 'onchange'=> 'pro($(this))'

                ])->label(false);  
            ?>
        </div>
    </div>    

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 10, // the maximum times, an element can be added (default 999)
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
        <tr class="<?= $inventory->color_class?>">
            <th class="text-center">Item</th>
            <th class="text-center">Quantity</th>
            <th class="text-center">Price</th>
            <th class="text-center">LineTotal</th>
            <th class="text-center">
                <button type="button" class="add-item btn  btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
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
            <td class="text-center">
                <?= $form->field($modelItem, "[{$i}]product_id")->dropDownList(
                        ArrayHelper::map(Stock::find()
                                ->where(['inventory_id' => $inventory->id])
                                ->andWhere('quantity > 0')
                                ->all(), 'product_id', 'product_name'),
                        [
                            'prompt'=>'Select A Product ',
                            'onchange'=> 'pro($(this))'

                        ])->label(false); 
                ?>
            </td>
            <td class="text-center">
                <?= $form->field($modelItem, "[{$i}]quantity")
                    ->textInput(
                        [
                            'type' => 'number', 
                            'onchange' => 'check($(this))',
                            'readonly' => true, 
                            'placeholder'=>'Quantity'
                        ])
                    ->label(false) 
                ?>
            </td>
            <td class="text-center">
                <?= $form->field($modelItem, "[{$i}]selling_rate")
                    ->textInput(
                        [
                            'type' => 'number',
                            'placeholder'=>'Price',
                            'disabled' => true,
                            // 'onchange' => 'check($(this))',
                        ])
                    ->label(false) 
                ?>
            </td>
            <td class="text-center">
                <?= $form->field($modelItem, "[{$i}]buying_rate")
                    ->textInput(
                        [   
                            'class' => 'form-control totalLinePrice',
                            'type' => 'number', 
                            'disabled' => True,
                            'onchange' => 'calculateTotal()', 
                            'placeholder'=>'LineTotal'
                        ])
                    ->label(false)
                ?>
            </td>
            <td class="text-center">
                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
            </td>
        <?php endforeach; ?>
    </table>
    <hr style=" border-bottom: 1px solid #000;">

    <?php DynamicFormWidget::end(); ?>
        <div class="col-sm-offset-8">
            <table class="table table-responsive">
                <tr>
                    <td> Total</td>
                    <td> 
                        <?= $form->field($model, 'amount')
                            ->textInput(
                                [
                                    'placeholder'=>'Total', 
                                    'onchange'=> 'calculateAmountDue()',
                                    'readonly' => true,
                                ])->label(false) 
                        ?>
                    </td>
                </tr>
                <tr>
                    <td> Pay</td>
                    <td> 
                        <?= $form->field($model, 'pay')
                            ->textInput(
                            [
                                'placeholder'=>'Pay',
                                'type' => 'number',
                                'onchange'=> 'calculateAmountDue()',
                            ])->label(false) 
                        ?> 
                    </td>
                </tr>

                <!-- <tr>
                    <td id="info">
                        AMOUNT DUE:
                    </td>
                    <td>
                        
                    </td>
                </tr> -->
                <hr style=" border-bottom: 4px solid #000;">
            </table>
        </div>
        <div class="col-sm-offset-8">
            <div id="info" >
                 AMOUNT DUE:  <?= $form->field($model, 'amountDue')
                            ->textInput()->label(false);  ?>
                <hr style=" border-bottom: 4px solid #3455;">
            </div>
        </div>
        
    
    <div class="form-group">
        <?= Html::submitButton($modelItem->isNewRecord ? 'Create' : 'Update', ['class' => "$inventory->color_class btn btn-flat btn-block"]) ?>
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

$(document).on('change keyup blur','.invoices-pay',function(){
    calculateAmountDue();
});

JS;
$this->registerJs($script);
?>  
