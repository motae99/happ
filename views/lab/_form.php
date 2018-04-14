<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;use kartik\select2\Select2;
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

<div class="lab-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'الأسم')])->label(false) ?>
    
     <?= $form->field($model, 'state')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'الوﻻية')])->label(false) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'المدينة')])->label(false) ?>
    
    <?= $form->field($model, 'address')->textarea(['rows' => 2, 'placeholder' => Yii::t('app', 'العنوان')])->label(false) ?>

    <?= $form->field($model, 'phone')->textInput(['type' => 'number', 'max' => 9999999999, 'placeholder' => Yii::t('app', 'تلفون ')])->label(false) ?>

    <?= $form->field($model, 'secondary_phone')->textInput(['type' => 'number', 'max' => 9999999999, 'placeholder' => Yii::t('app', 'تلفون ')])->label(false) ?>


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


    <?= $form->field($model, 'from_hour')->widget(TimePicker::classname(), [])->label(false);?>

    <?= $form->field($model, 'to_hour')->widget(TimePicker::classname(), [])->label(false);?>

    <?= $form->field($model, 'logitude')->textInput(['placeholder'=> Yii::t('app', 'خط الطول')])->label(false) ?>
    
    <?= $form->field($model, 'latitude')->textInput(['placeholder'=> Yii::t('app', 'خط العرض')])->label(false) ?>
    
    <?= $form->field($model,'photo')->fileInput(['data-filename-placement' => "inside", 'title' => Yii::t('app', 'الصورة'), 'onchange'=>'uploadImage(this)', 'data-target'=>'#stu-photo-prev'])->label(false) ?>

    

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
