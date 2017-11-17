<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Stocking */
/* @var $form yii\widgets\ActiveForm */
?>

<?php  $url = \yii\helpers\Url::to(['product/fetch']);?>
  <?php  $detail = \yii\helpers\Url::to(['product/detail']);?>



<div class="stocking-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'product_id')->widget(Select2::classname(), [
                      'options' => ['placeholder' => 'Type Product name ...'],
                      'pluginOptions' => [
                          'allowClear' => false,
                          'minimumInputLength' => 4,
                          'ajax' => [
                              'url' => $url,
                              'dataType' => 'json',
                              'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                          ],
                          'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                          'templateResult' => new JsExpression('function(name) { return name.text; }'),
                          'templateSelection' => new JsExpression('function (name) { return name.text; }'),
                      ],
      
                  ]);
      
        ?>

    <?= $form->field($model, 'inventory_id')->textInput() ?>

    <?= $form->field($model, 'buying_price')->textInput() ?>

    <?= $form->field($model, 'selling_price')->textInput() ?>

    <?= $form->field($model, 'quantity')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

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
      },
          error: function (jqXHR, textStatus, errorThrown) {
              //console.log('An error occured!');
              alert('Error in ajax request');
          }
    });
  });
});
JS;
$this->registerJs($script);
?>