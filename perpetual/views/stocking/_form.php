<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

use app\models\Inventory;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Stocking */
/* @var $form yii\widgets\ActiveForm */
?>

<?php  $url = \yii\helpers\Url::to(['product/fetch']);?>
  <?php  $detail = \yii\helpers\Url::to(['product/detail']);?>



<div class="stocking-form">
<div class="row">
    <?php $form = ActiveForm::begin(
        [   
            'id' => 'stocking-form',
            'options'=>['method' => 'post'],
            'action' => Url::to(['stocking/create']),
            
        ]); 
    ?>
    <div class="col-lg-6 eArLangCss">
      <?= $form->field($model, 'inventory_id')->dropDownList(
                                  ArrayHelper::map(Inventory::find()->all(), 'id', 'name'),
                                  ['prompt'=>'Select An Inventory '])->label(false); 
      ?>
    </div>
    <div class="col-lg-6 eArLangCss">
      <?= $form->field($model, 'product_id')->widget(Select2::classname(), [
                  'options' => ['placeholder' => 'Type Product name ...'],
                  'pluginOptions' => [
                      'allowClear' => false,
                      'minimumInputLength' => 3,
                      'ajax' => [
                          'url' => $url,
                          'dataType' => 'json',
                          'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                      ],
                      'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                      'templateResult' => new JsExpression('function(name) { return name.text; }'),
                      'templateSelection' => new JsExpression('function (name) { return name.text; }'),
                  ],
              ])->label(false);
  
      ?>
    </div>
    <div class="col-lg-5 eArLangCss">
      <?= $form->field($model, 'buying_price')->textInput(['placeholder'=>'buying_price', 'maxlength' => true])->label(false) ?>
    </div>
    <div class="col-lg-2 eArLangCss">
      <?= $form->field($model, 'percentage')->textInput(['placeholder'=>'percentage', 'maxlength' => true])->label(false) ?>
    </div>
    <div class="col-lg-5 eArLangCss">
      <?= $form->field($model, 'selling_price')->textInput(['placeholder'=>'selling_price', 'maxlength' => true])->label(false) ?>
    </div>

    <div class="col-lg-12 eArLangCss">
      <?= $form->field($model, 'quantity')->textInput(['placeholder'=>'quantity', 'maxlength' => true])->label(false) ?>
    </div>
    <div class="col-lg-12 eArLangCss">
      <div class="form-group">
          <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn bg-maroon btn-flat btn-block']) ?>
      </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>

<?php 
$script = <<< JS
$(document).ready(function() {
 
$('#stocking-product_id').change(function(){  
    product_id = {id: $(this).val()}; 
    $.ajax({
     url: '$detail' ,
     dataType: 'json',
     method: 'GET',
     data: product_id,
     success: function (data, textStatus, jqXHR) {
       $('#stocking-selling_price').val(data.selling_price);
       $('#stocking-buying_price').val(data.buying_price);
       $('#stocking-active').val(data.active);
       $('#stocking-percentage').val(data.percentage);
       if(data.active == "percentage"){
        $('#stocking-selling_price').prop("readonly", true);
        // $('div .field-stocking-selling_price').hide();
       }else{
        $('#stocking-percentage').prop("readonly", true);
        // $('div .field-stocking-percentage').hide();

       }
      },
          error: function (jqXHR, textStatus, errorThrown) {
              //console.log('An error occured!');
              alert('Error in ajax request');
          }
    });
  });

  $("#stocking-buying_price, #stocking-selling_price").change(function() {
      var priceOne = parseFloat($("#stocking-buying_price").val());
      var priceTwo = parseFloat($("#stocking-selling_price").val());
      if ($("#stocking-buying_price").val() && $("#stocking-selling_price").val()){     
        $("#stocking-percentage").val("");
        $('#stocking-percentage').val(((priceTwo - priceOne) / priceOne * 100));
      }

  });

    $("#stocking-percentage").change(function() {
        var priceOne = parseFloat($("#stocking-buying_price").val());
        var rate = parseFloat($("#stocking-percentage").val());

        if ($("#stocking-percentage").val() && $("#stocking-buying_price").val()){
          $('#stocking-selling_price').val("");
          $('#stocking-selling_price').val(((priceOne * rate)/ 100 + priceOne));
        }
    });
});
JS;
$this->registerJs($script);
?>