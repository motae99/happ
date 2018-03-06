<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use app\models\Clinic;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Physician */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Physicians'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="physician-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="availability-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($available, 'clinic_id')->dropDownList(
                        ArrayHelper::map(Clinic::find()->all(), 'id', 'name'),
                        [
                            'prompt'=>Yii::t('app', 'Health Center'),
                        ])->label(false);  
    ?>

    <?= $form->field($available, 'date')->dropDownList(['sat' => Yii::t('app', 'Saterday') ,'sun' => Yii::t('app', 'Sunday'), 'mon' => Yii::t('app', 'Monday'), 'tue' => Yii::t('app', 'Tuseday'), 'wen' => Yii::t('app', 'Wensday'), 'thu' => Yii::t('app', 'Thursday'), 'fri' => Yii::t('app', 'Friday')])->label(false); ?>

    <?= $form->field($available, 'from_time')->textInput() ?>

    <?= $form->field($available, 'to_time')->textInput() ?>

    <?= $form->field($available, 'appointment_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($available, 'revisiting_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($available, 'max')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
