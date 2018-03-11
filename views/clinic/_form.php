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
    <?= $form->field($model, 'type')->dropDownList(['مستشفى خاص' => Yii::t('app', 'مستشفى خاص'), 'مستشفى حكومي' => Yii::t('app', 'مستشفى حكومي'), 'مستوصف' => Yii::t('app', 'مستوصف'), 'عيادة' => Yii::t('app', 'عيادة'), 'مركز صحي' => Yii::t('app', 'مركز صحي'), 'مستشفىات دولية العﻻج' => Yii::t('app', 'مستشفىات دولية العﻻج'), 'العﻻج الطبيعي' => Yii::t('app', 'العﻻج الطبيعي'), 'مجمعات طبية' => Yii::t('app', 'مجمعات طبية'), 'الأسنان' => Yii::t('app', 'الأسنان'), 'البصريات' => Yii::t('app', 'البصريات')], ['prompt' => Yii::t('app', 'اختار نوع المؤسسه ')])->label(false); ?>
    </div>
    <div class="col-lg-6">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'الأسم')])->label(false) ?>
    </div>

</div>
   

    <?= $form->field($model, 'state')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'الوﻻية')])->label(false) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'المدينة')])->label(false) ?>
    
    <?= $form->field($model, 'address')->textarea(['rows' => 2, 'placeholder' => Yii::t('app', 'العنوان')])->label(false) ?>

    <?= $form->field($model, 'manager')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'المدير الطبي')])->label(false) ?>

    <?= $form->field($model, 'primary_contact')->textInput([ 'placeholder' => Yii::t('app', 'تلفون المؤسسه')])->label(false) ?>

    <?= $form->field($model, 'secondary_contact')->textInput(['placeholder'=> Yii::t('app', 'تلفون اضافي')])->label(false) ?>
    
    <?= $form->field($model, 'fax')->textInput(['placeholder'=> Yii::t('app', 'رقم الفاكس')])->label(false) ?>
    
    <?= $form->field($model, 'email')->textInput(['placeholder'=> Yii::t('app', 'الموقع الالكتروني')])->label(false) ?>

    <?= $form->field($model, "working_days")->widget(Select2::classname(), 
        [
            'data' =>['sat' => Yii::t('app', 'Saterday') ,'sun' => Yii::t('app', 'Sunday'), 'mon' => Yii::t('app', 'Monday'), 'tue' => Yii::t('app', 'Tuseday'), 'wen' => Yii::t('app', 'Wensday'), 'thu' => Yii::t('app', 'Thursday'), 'fri' => Yii::t('app', 'Friday')],
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
    <?= $form->field($model, 'app_service')->textInput(['placeholder'=> Yii::t('app', 'خدمة الحجز عبر التطبيق')])->label(false) ?>
    <?= $form->field($model,'photo')->fileInput(['data-filename-placement' => "inside", 'title' => Yii::t('app', 'الصورة'), 'onchange'=>'uploadImage(this)', 'data-target'=>'#stu-photo-prev'])->label(false) ?>
    <div class="hint col-xs-12 col-sm-12" style="color:red;padding-top:1px"><b> </b>&nbsp;<?php echo Yii::t('app', ' jpg jpeg png فقط صور على الامتدادات'); ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'حفظ'), ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
