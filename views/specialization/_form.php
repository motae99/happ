<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Clinic;
use app\models\Physician;


/* @var $this yii\web\View */
/* @var $model app\models\Specialization */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="specialization-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'clinic_id')->dropDownList(
                        ArrayHelper::map(Clinic::find()->all(), 'id', 'name'),
                        [
                            'prompt'=>Yii::t('app', 'أسم الرفق الصحي'),
                        ])->label(false);  
    ?>

    <?= $form->field($model, 'physician_id')->dropDownList(
                        ArrayHelper::map(Physician::find()->all(), 'id', 'name'),
                        [
                            'prompt'=>Yii::t('app', 'أسم الطبيب'),
                        ])->label(false);  
    ?>

           


    <?= $form->field($model, 'specialty')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
