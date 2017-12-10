<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>
<script>

function shift(){
    var type = $('#product-active').val();
    if(type == "selling_price"){
        $('#product-percentage').prop("readonly", true);
        $('#product-percentage').val("");
        $('#product-selling_price').val("");
        $('#product-selling_price').prop("readonly", false);
    }else{
        $('#product-percentage').prop("readonly", false);
        $('#product-percentage').val("");
        $('#product-selling_price').val("");
        $('#product-selling_price').prop("readonly", true);
    }
    
}

</script>

<div class="product-form">

    <?php $form = ActiveForm::begin([   
            'id' => 'product-create-form',
            'options'=>['method' => 'post'],
            'action' => Url::to(['product/create']),
            
        ]); 
    ?>
    <div class="row">
        <div class="col-sm-6 eArLangCss">
            <?= $form->field($model, 'category_id')->dropDownList(
                                ArrayHelper::map(Category::find()->all(), 'id', 'name'),
                                ['placeholder'=>Yii::t('inventory', 'Category')])->label(false); 
            ?>
        </div>
        <div class="col-sm-6 eArLangCss">
            <?= $form->field($model, 'product_name')->textInput(['placeholder'=>Yii::t('inventory', 'Item Name'), 'maxlength' => true])->label(false) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2 eArLangCss">
            <?= $form->field($model, 'no')->textInput(['placeholder'=>Yii::t('inventory', 'Item No'), 'maxlength' => true])->label(false) ?>
        </div>
        <div class="col-sm-10 eArLangCss">
            <?= $form->field($model, 'description')->textInput(['placeholder'=>Yii::t('inventory', 'Item Description'), 'rows' => 3])->label(false) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-6 eArLangCss">
            <?php $model->active = 'selling_price';?>
            <?= $form->field($model, 'active')->dropDownList([ 'selling_price' => 'Selling Price', 'percentage' => 'Percentage',],  ['onchange' => 'shift()'])->label(false) ?>
        </div>
        <div class="col-sm-6 eArLangCss">
            <?= $form->field($model, 'minimum')->textInput(['placeholder'=>Yii::t('inventory', 'minimum'), 'maxlength' => true])->label(false) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-5 eArLangCss">
            <?= $form->field($model, 'buying_price')->textInput(['placeholder'=>Yii::t('inventory', 'Buying Price'), 'maxlength' => true])->label(false) ?>
        </div>
        <div class="col-sm-2 eArLangCss">
            <?= $form->field($model, 'percentage')->textInput(['readonly' => true, 'placeholder'=>Yii::t('inventory', 'Margin Ratio'), 'maxlength' => true])->label(false) ?>
        </div>
        <div class="col-sm-5 eArLangCss">
            <?= $form->field($model, 'selling_price')->textInput(['placeholder'=>Yii::t('inventory', 'Selling Price'), 'maxlength' => true])->label(false) ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('inventory', 'Add this Item'), ['class' => 'btn btn-block btn-flat bg-orange']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<< JS
$(document).ready(function(){
    $("#product-buying_price, #product-selling_price").change(function() {
      var priceOne = parseFloat($("#product-buying_price").val());
      var priceTwo = parseFloat($("#product-selling_price").val());
      var rate = parseFloat($("#product-percentage").val());
      if ($("#product-buying_price").val() && $("#product-selling_price").val()){     
      $('#product-percentage').val(((priceTwo - priceOne) / priceOne * 100));
    }

    });

    $("#product-percentage").change(function() {
        var priceOne = parseFloat($("#product-buying_price").val());
        var rate = parseFloat($("#product-percentage").val());

        if ($("#product-percentage").val() && $("#product-buying_price").val()){
         $('#product-selling_price').val(((priceOne * rate)/ 100 + priceOne));
        }
    });
    
})
JS;
$this->registerJs($script);
?>