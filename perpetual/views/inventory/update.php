<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Inventory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-form">
    <div class="row">
    <?php $form = ActiveForm::begin(
        [   
            'id' => 'inventory-update-form',
            'options'=>['method' => 'post'],
            'action' => Url::to(['inventory/update', 'id' =>$model->id ]),
            
        ]); 
    ?>

    <div class="col-lg-12 eArLangCss">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false) ?>

    </div>
    <div class="col-lg-12 eArLangCss">
    <?= $form->field($model, 'address')->textarea(['rows' => 3])->label(false) ?>
    </div>
    <div class="col-lg-12 eArLangCss">
    <?= $form->field($model, 'phone_no')->textInput(['maxlength' => true])->label(false) ?>
    </div>
    <div class="col-lg-12 eArLangCss">
    <ul class="fc-color-picker" id="color-chooser">
      <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
      <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
      <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
      <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
      <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
      <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
      <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
      <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
      <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
      <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
      <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
      <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
      <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
    </ul>
    </div>
    <div class="col-lg-12 eArLangCss" id="color">
    <?= $form->field($model, 'color_class')->textInput(['placeholder'=>Yii::t('inventory', 'Select Color'), 'maxlength' => true])->label(false) ?>

    </div>
    <div class="col-lg-12 eArLangCss">
    <div class="form-group" id="bu">
        <?= Html::submitButton(Yii::t('inventory', 'Update This Inventory'), ['class' => 'btn btn-flat btn-block']) ?>
    </div>

    </div>


    <?php ActiveForm::end(); ?>
    </div>
</div>
<?php 
$script = <<< JS
$(document).ready(function () {
    $("#color").hide();
});

$("a").click(function() {
   var myClass = this.className;
   var length = myClass.length;
    var s = 'bg' + myClass.substr(4, length);
    // alert($("#inventory-color_clas").val());
    // alert(s);
    $("#inventory-color_class").val(s);
    $('button').addClass(s);

});
JS;
$this->registerJs($script);
?>  
