<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\time\TimePicker; 


/* @var $this yii\web\View */
/* @var $model app\models\Clinic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clinic-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-lg-6 eArLangCss">
    <?= $form->field($model, 'type')->dropDownList(['مستشفى خاص' => Yii::t('app', 'مستشفى خاص'), 'مستشفى حكومي' => Yii::t('app', 'مستشفى حكومي'), 'مستوصف' => Yii::t('app', 'مستوصف'), 'عيادة' => Yii::t('app', 'عيادة'), 'مركز صحي' => Yii::t('app', 'مركز صحي'), 'مستشفىات دولية العﻻج' => Yii::t('app', 'مستشفىات دولية العﻻج'), 'العﻻج الطبيعي' => Yii::t('app', 'العﻻج الطبيعي'), 'مجمعات طبية' => Yii::t('app', 'مجمعات طبية'), 'الأسنان' => Yii::t('app', 'الأسنان'), 'البصريات' => Yii::t('app', 'البصريات'), 'مؤسسة طبية عسكرية' => Yii::t('app', 'مؤسسة طبية عسكرية'), 'مراكز التجميل' => Yii::t('app', 'مراكز التجميل')], ['prompt' => Yii::t('app', 'اختار نوع المؤسسه '),])->label(false); ?>
    </div>
    <div class="col-lg-6 eArLangCss">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'الأسم')])->label(false) ?>
    </div>

</div>
<div class="row">
	<div class="col-lg-4 eArLangCss">
    <?= $form->field($model, 'state')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'الوﻻية')])->label(false) ?>
    </div>
    <div class="col-lg-4 eArLangCss">
    <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'المدينة')])->label(false) ?>
    </div>
    <div class="col-lg-4 eArLangCss">
    <?= $form->field($model, 'address')->textarea(['rows' => 1, 'placeholder' => Yii::t('app', 'العنوان')])->label(false) ?>
    </div>

</div>
<div class="row">
	<div class="col-lg-6 eArLangCss">
    <?= $form->field($model, 'manager')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'المدير الطبي')])->label(false) ?>
    </div>
    <div class="col-lg-6 eArLangCss">
    <?= $form->field($model, 'primary_contact')->textInput(['type' => 'number', 'max' => 9999999999,'placeholder' => Yii::t('app', 'تلفون المؤسسه')])->label(false) ?>
    </div>
    <div class="col-lg-4 eArLangCss">
    <?= $form->field($model, 'secondary_contact')->textInput(['type' => 'number', 'max' => 9999999999,'placeholder' => Yii::t('app', 'تلفون بديل')])->label(false) ?>
    </div> 
    <div class="col-lg-4 eArLangCss">
    <?= $form->field($model, 'fax')->textInput(['type' => 'number', 'max' => 9999999999, 'placeholder'=> Yii::t('app', 'رقم الفاكس')])->label(false) ?>
    </div>
     <div class="col-lg-4 eArLangCss">
    <?= $form->field($model, 'email')->textInput(['placeholder'=> Yii::t('app', 'الموقع الالكتروني')])->label(false) ?>
    </div>

</div>
   


    


    

    
    

    
    
    <?= $form->field($model, 'special_services')->textarea(['rows' => 6, 'placeholder'=> Yii::t('app', 'الخدمات الخاصه')])->label(false) ?>
    <?= $form->field($model, 'info')->textarea(['rows' => 6, 'placeholder'=> Yii::t('app', 'المعلومات العامه')])->label(false) ?>
    <?= $form->field($model, 'app_service')->dropDownList(['yes' => Yii::t('app', 'متوفرة'), 'no' => Yii::t('app', 'جاري التعاقد')], ['prompt' => Yii::t('app', 'حدمة الحجز ')])->label(false) ?>
    <?= $form->field($model, 'longitude')->textInput(['placeholder'=> Yii::t('app', 'خط الطول')])->label(false) ?>
    <?= $form->field($model, 'latitude')->textInput(['placeholder'=> Yii::t('app', 'خط العرض')])->label(false) ?>
    
    <div class="col-lg-12 eArLangCss" id="color">
    <?= $form->field($model, 'color')->textInput(['placeholder' => Yii::t('client', 'Pick a Color')])->label(false); ?>
    </div>

    <div class="col-lg-6 eArLangCss">
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

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'تعديل'), ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

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
    $("#clinic-color").val(s);
    $('button').addClass(s);

});
JS;
$this->registerJs($script);
?> 
