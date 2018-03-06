<div class="padding-v-md">

        <div class="line line-dashed"></div>

    </div>




     <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', 
        'widgetBody' => '.container-items', 
        'widgetItem' => '.item', 
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-item', 
        'deleteButton' => '.remove-item', 
        'model' => $availability[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'clinic_id',
            'date',
            'appointment_fee',
            'revisiting_fee',
            'from_time',
            'to_time',
        ],
    ]); ?>
    <div>
        <button type="button" class="add-item btn btn-success btn-xs"><span class="fa fa-plus"></span></button>
    </div>
    <div class="container-items">
        <?php foreach ($availability as $i => $ava): ?>
        <div class="item">
            <div class="row">
                <div class="col-lg-12">
                    <?php if (! $ava->isNewRecord) { echo Html::activeHiddenInput($ava, "[{$i}]id");} ?>
                    <div class="col-lg-9">
                    <?= $form->field($ava, '[{$i}]clinic_id')->dropDownList(
                        ArrayHelper::map(Clinic::find()->all(), 'id', 'name'),
                        [
                            'prompt'=>Yii::t('app', 'Health Center'),
                        ])->label(false); 
                    ?>
                    </div>
                    <div class="col-lg-3">
                    <?= $form->field($ava, '[{$i}]max')->textInput(['placeholder'=>Yii::t('app', 'Max')])->label(false) ?>
                    </div>
                    <div class="col-lg-6">
                    <?= $form->field($ava, '[{$i}]date')->dropDownList(['sat' => Yii::t('app', 'Saterday') ,'sun' => Yii::t('app', 'Sunday'), 'mon' => Yii::t('app', 'Monday'), 'tue' => Yii::t('app', 'Tuseday'), 'wen' => Yii::t('app', 'Wensday'), 'thu' => Yii::t('app', 'Thursday'), 'fri' => Yii::t('app', 'Friday')])->label(false); ?>
                    </div>
                    <div class="col-lg-3">
                    <?= $form->field($ava, '[{$i}]from_time')->textInput(['placeholder'=>Yii::t('app', 'F_time')])->label(false) ?>
                    </div>
                    <div class="col-lg-3">
                    <?= $form->field($ava, '[{$i}]to_time')->textInput(['placeholder'=>Yii::t('app', 'T_time')])->label(false) ?>
                    </div>
                    <div class="col-lg-6">
                    <?= $form->field($ava, '[{$i}]appointment_fee')->textInput(['placeholder'=>Yii::t('app', 'Fees')])->label(false) ?>
                    </div>
                    <div class="col-lg-6">
                    <?= $form->field($ava, '[{$i}]revisiting_fee')->textInput(['placeholder'=>Yii::t('app', 'R_fees')])->label(false) ?>
                    </div>
                </div>
                <!-- <div class="col-lg-7">
                    <?php /* echo $this->render('_insurance', [
                        'form' => $form,
                        'i' => $i,
                        'insurance' => $insurance[$i],
                    ])*/ ?>
                </div> -->
            </div>
        <div>
            <button type="button" class="remove-item btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>
        </div>
        </div>

        <?php endforeach; ?>
    </div>
        


    <?php DynamicFormWidget::end(); ?>