<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2; 
use kartik\time\TimePicker; 


/* @var $this yii\web\View */
/* @var $model app\models\Pharmacy */
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

<div class="pharmacy-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'phone')->textInput(['type' => 'number', 'max' => 9999999999,]) ?>

    <?= $form->field($model, 'owner_name')->textInput(['placeholder' => 'أسم صاحب الرخصة'])->label(false) ?>

    <?= $form->field($model, 'website')->textInput(['placeholder' => 'الموقع الالكتروني'])->label(false) ?>

    <?= $form->field($model, 'secondary_phone')->textInput(['placeholder' => 'هاتف مساءي'])->label(false) ?>

    <?= $form->field($model, 'working_days')->widget(Select2::classname(), 
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

    <?= $form->field($model, 'app_service')->dropDownList([ 'yes' => 'Yes', 'no' => 'No', ], ['prompt' => '']) ?>



    <?= $form->field($model, 'logitude')->textInput() ?>

    <?= $form->field($model, 'latitude')->textInput() ?>

    <?= $form->field($model,'photo')->fileInput(['data-filename-placement' => "inside", 'title' => Yii::t('app', 'الصورة'), 'onchange'=>'uploadImage(this)', 'data-target'=>'#stu-photo-prev'])->label(false) ?>
    

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
