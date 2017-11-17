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



function pro(item){
    var index  = item.attr("id").replace(/[^0-9.]/g, ""); 
    var product_id = $('#invoiceproduct-' + index + '-product_id').val();

    product_id = product_id == "" ? 0 : Number(product_id.split(",").join(""));
    $.ajax({
         url: 'details?id=' + product_id,
         dataType: 'json',
         method: 'GET',
         data: product_id,
         success: function (data, textStatus, jqXHR) {
            $('#invoiceproduct-' + index + '-selling_rate').val(data.selling_price) ;
            $('#invoiceproduct-' + index + '-quantity').prop('min', 1);
            $('#invoiceproduct-' + index + '-quantity').prop('max', data.quantity);
            $('#invoiceproduct-' + index + '-buying_rate').val('your quantity');
         },
         //  beforeSend: function (xhr) {
         //      alert('loading!');
         // },
          error: function (jqXHR, textStatus, errorThrown) {
            $('#invoiceproduct-' + index + '-selling_rate').val('') ;
            $('#invoiceproduct-' + index + '-quantity').val('') ;
            $('#invoiceproduct-' + index + '-buying_rate').val('') ;
              
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
        alert('you dont have this much avaiablabe is:' + max);  
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
    // amountPaid = $('#invoices-pay').val();
    // total = $('#invoices-amount').val();
    // if(amountPaid <= total ){
    //     amountDue = parseFloat(total) - parseFloat( amountPaid );
    //     // alert("amount due is :" + amountDue);
    //     // $('.amountDue').val( amountDue.toFixed(2) );
    //     $('#info').show();
    //     $('.showAmount').text(data.amountDue);

    // }else{
    //     total = parseFloat(total).toFixed(2);
    //     // $('.amountDue').val( total);
    //     $('#invoices-pay').val('0');
    //     $('#info').show();
    //     $('.showAmount').text(data.amountDue);
    // }
}

</script>
<div>
</div>
<div class="invoices-form" style="margin-top: 30px;">
    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'client_id')
                ->dropDownList(ArrayHelper::map(Client::find()->all(), 'id', 'client_name'),
                [
                    'prompt'=>'Client Name',
                    // 'onchange'=> 'pro($(this))'

                ])->label(false);  
            ?>
        </div>
        <div class="col-sm-6">
            
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

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="pull-left">
                <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="container-items"><!-- widgetBody -->
                <?php foreach ($modelsItem as $i => $modelItem): ?>
                <div class="item panel panel-default"><!-- widgetItem -->
                    
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelItem->isNewRecord) {
                                echo Html::activeHiddenInput($modelItem, "[{$i}]id");
                            }
                        ?>
                        <div class="row">
                            <div class="col-sm-4">
                                <?php echo $form->field($modelItem, "[{$i}]product_id")
                                    ->dropDownList(
                                        ArrayHelper::map(Stock::find()
                                                ->where(['inventory_id' => 12])
                                                ->andWhere('quantity > 0')
                                                ->all(), 'id', 'product_name'),
                                        [
                                            'prompt'=>'Select A Product ',
                                            'onchange'=> 'pro($(this))'

                                        ])
                                    ->label(false);


                                ?>
                            </div>
                            <div class="col-sm-2">
                                <?= $form->field($modelItem, "[{$i}]quantity")
                                    ->textInput(
                                        [
                                            'type' => 'number', 
                                            'onchange' => 'check($(this))', 
                                            'placeholder'=>'Quantity'
                                        ])
                                    ->label(false) 
                                ?>
                                <span class="waning " ></span>   
                            </div>
                            <div class="col-sm-2">
                                <?= $form->field($modelItem, "[{$i}]selling_rate")
                                    ->textInput(
                                        [
                                            'type' => 'number',
                                            'placeholder'=>'Price',
                                            // 'onchange' => 'check($(this))',
                                        ])
                                    ->label(false) 
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-10">
                                    <?= $form->field($modelItem, "[{$i}]buying_rate")
                                        ->textInput(
                                            [   
                                                'class' => 'form-control totalLinePrice disable',
                                                'type' => 'number', 
                                                'onchange' => 'calculateTotal()', 
                                                'placeholder'=>'Total'
                                            ])
                                        ->label(false)
                                    ?>
                                </div>
                                <div class="col-sm-2">
                                    <div class="pull-right">
                                        <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div> 
    </div><!-- .panel -->
    <?php DynamicFormWidget::end(); ?>
    <div class="row">
        <div class="col-sm-8">
            <div id="info hide">
                Due Amount: <span class="showAmount"> </span>
            </div>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'amount')
                ->textInput(
                    [
                        'placeholder'=>'Total', 
                        'onchange'=> 'calculateAmountDue()',
                    ])->label(false) 
            ?>
            <?= $form->field($model, 'pay')
                ->textInput(
                [
                    'placeholder'=>'Pay',
                    'type' => 'number',
                    'onchange'=> 'calculateAmountDue()',
                ])->label(false) 
            ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($modelItem->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
$script = <<< JS
$(".dynamicform_wrapper").on("afterDelete", function(e) {
    calculateTotal();
});

$(document).on('change keyup blur','.invoices-pay',function(){
    calculateAmountDue();
});

JS;
$this->registerJs($script);
?>  
