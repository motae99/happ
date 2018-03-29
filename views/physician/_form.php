<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use kartik\date\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\Clinic;
/* @var $this yii\web\View */
/* @var $model app\models\Physician */
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

<div class="physician-form">

    <?php $form =  ActiveForm::begin(['id' => 'dynamic-form']);?>
    <div class="row">
        <div class="col-lg-8">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'الأسم')])->label(false) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'contact_no')->textInput(['type' => 'number', 'max' => 9999999999, 'placeholder' => Yii::t('app', 'رقم الهاتف')])->label(false) ?>
        </div>
        <div class="col-lg-12">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'البريد الالكتروني')])->label(false) ?>
        </div>
        <div class="col-lg-12">
            <?= $form->field($model, 'regestration_no')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'الرقم الطبي')])->label(false) ?>
        </div>
        <div class="col-lg-12">
            <?= $form->field($model, 'specialization_id')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'التخصص')])->label(false) ?>
        </div>
        <div class="col-lg-12">
            <?= $form->field($model, 'university')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'جامعة التخرج')])->label(false) ?>
        </div>
        <div class="col-lg-12">
            <?= $form->field($model, 'extra_info')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'معلومات اضافية')])->label(false) ?>
        </div>
        <div>
            <?= $form->field($model,'photo')->fileInput(['data-filename-placement' => "inside", 'title' => Yii::t('app', 'الصورة'), 'onchange'=>'uploadImage(this)', 'data-target'=>'#stu-photo-prev'])->label(false) ?>
        </div>
        
    </div>

    

    <?php //echo $form->field($insurance, 'insurance_id')->textInput() ?>
    <?php //echo $form->field($insurance, 'patient_payment')->textInput() ?>
    <?php //echo $form->field($insurance, 'insurance_refund')->textInput() ?>
    <?php //echo $form->field($insurance, 'contract_expiry')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
