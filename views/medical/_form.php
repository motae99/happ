<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\time\TimePicker; 


/* @var $this yii\web\View */
/* @var $model app\models\Clinic */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
.stu-photo-form .file-input-wrapper {
    float: none;
    margin-top: 2%;
    width: auto;
}
</style>
<script>
// *** Upload Image Preview ***
    var imageTypes = ['jpeg', 'jpg', 'png', 'gif']; //Validate the images to show
        function showImage(src, target)
        {
            var fr = new FileReader();
            fr.onload = function(e)
            {
                target.src = this.result;
            };
            fr.readAsDataURL(src.files[0]);
        }
        var uploadImage = function(obj)
        {
            var val = obj.value;
            var lastInd = val.lastIndexOf('.');
            var ext = val.slice(lastInd + 1, val.length);
            if (imageTypes.indexOf(ext) !== -1)
            {
                var id = $(obj).data('target');                    
                var src = obj;
                var target = $(id)[0];                    
                showImage(src, target);
            }
        }

// *** file upload input style ***
$(document).ready(function(){
     $('#<?php echo Html::getInputId($model, "photo"); ?>').bootstrapFileInput();
});
</script>
<div class="clinic-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-lg-6">
    <?= $form->field($model, 'type')->dropDownList(['مستشفى خاص' => Yii::t('app', 'مستشفى خاص'), 'مستشفى حكومي' => Yii::t('app', 'مستشفى حكومي'), 'مستوصف' => Yii::t('app', 'مستوصف'), 'عيادة' => Yii::t('app', 'عيادة'), 'مركز صحي' => Yii::t('app', 'مركز صحي'), 'مستشفىات دولية العﻻج' => Yii::t('app', 'مستشفىات دولية العﻻج'), 'العﻻج الطبيعي' => Yii::t('app', 'العﻻج الطبيعي'), 'مجمعات طبية' => Yii::t('app', 'مجمعات طبية'), 'الأسنان' => Yii::t('app', 'الأسنان'), 'البصريات' => Yii::t('app', 'البصريات'), 'مؤسسة طبية عسكرية' => Yii::t('app', 'مؤسسة طبية عسكرية'), 'مراكز التجميل' => Yii::t('app', 'مراكز التجميل')], ['prompt' => Yii::t('app', 'اختار نوع المؤسسه '),])->label(false); ?>
    </div>
    <div class="col-lg-6">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'الأسم')])->label(false) ?>
    </div>

</div>
   

    <?= $form->field($model, 'state')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'الوﻻية')])->label(false) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'المدينة')])->label(false) ?>
    
    <?= $form->field($model, 'address')->textarea(['rows' => 2, 'placeholder' => Yii::t('app', 'العنوان')])->label(false) ?>

    <?= $form->field($model, 'manager')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'المدير الطبي')])->label(false) ?>

    <?= $form->field($model, 'primary_contact')->textInput(['type' => 'number', 'max' => 9999999999,'placeholder' => Yii::t('app', 'تلفون المؤسسه')])->label(false) ?>
    
    <?= $form->field($model, 'secondary_contact')->textInput(['type' => 'number', 'max' => 9999999999,'placeholder' => Yii::t('app', 'تلفون المؤسسه')])->label(false) ?>

    
    <?= $form->field($model, 'fax')->textInput(['type' => 'number', 'max' => 9999999999, 'placeholder'=> Yii::t('app', 'رقم الفاكس')])->label(false) ?>
    
    <?= $form->field($model, 'email')->textInput(['placeholder'=> Yii::t('app', 'الموقع الالكتروني')])->label(false) ?>

    <?= $form->field($model, "working_days")->widget(Select2::classname(), 
        [
            'data' =>['السبت' => Yii::t('app', 'السبت') ,'الأحد' => Yii::t('app', 'الأحد'), 'الأثنين' => Yii::t('app', 'الأثنين'), 'الثﻻثاء' => Yii::t('app', 'الثﻻثاء'), 'الأربعاء' => Yii::t('app', 'الأربعاء'), 'الخميس' => Yii::t('app', 'الخميس'), 'الجمعة' => Yii::t('app', 'الجمعة')],
            // 'language' => 'de',
            'options' => ['multiple' => true, 'placeholder' => 'أختار ايام العمل ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],

        ])->label(false);
    ?>

    
    <?= $form->field($model, 'start')->widget(TimePicker::classname(), [])->label(false);?>
    <?= $form->field($model, 'end')->widget(TimePicker::classname(), [])->label(false);?>

    <?= $form->field($model, 'special_services')->textarea(['rows' => 6, 'placeholder'=> Yii::t('app', 'الخدمات الخاصه')])->label(false) ?>
    <?= $form->field($model, 'info')->textarea(['rows' => 6, 'placeholder'=> Yii::t('app', 'المعلومات العامه')])->label(false) ?>
    <?= $form->field($model, 'app_service')->dropDownList(['yes' => Yii::t('app', 'متوفرة'), 'no' => Yii::t('app', 'جاري التعاقد')], ['prompt' => Yii::t('app', 'حدمة الحجز ')])->label(false) ?>
    <?= $form->field($model, 'longitude')->textInput(['placeholder'=> Yii::t('app', 'خط الطول')])->label(false) ?>
    <?= $form->field($model, 'latitude')->textInput(['placeholder'=> Yii::t('app', 'خط العرض')])->label(false) ?>
    <?= $form->field($model,'photo')->fileInput(['data-filename-placement' => "inside", 'title' => Yii::t('app', 'الصورة'), 'onchange'=>'uploadImage(this)', 'data-target'=>'#stu-photo-prev'])->label(false) ?>
    <div class="hint col-xs-12 col-sm-12" style="color:red;padding-top:1px"><b> </b>&nbsp;<?php echo Yii::t('app', ' jpg jpeg png فقط صور على الامتدادات'); ?>
    </div>

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
        <?= Html::submitButton(Yii::t('app', 'حفظ'), ['class' => 'btn btn-block btn-success']) ?>
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
