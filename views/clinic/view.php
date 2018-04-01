<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Clinic */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Clinics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clinic-view">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
        
    </p>
<div class="row">
    <div class="col-lg-6 eArLangCss">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                // 'id',
                'name',
                'state',
                'city',
                'address:ntext',
                'primary_contact',
                'secondary_contact',
                'longitude:ntext',
                'latitude:ntext',
                'type',
                'start',
                'end',
                'manager',
                'working_days',
                'email',
                'rate',
                'app_service',
                'color',
            ],
        ]) ?>
    </div>
    <div class="col-lg-6">
        <?= Html::button('<i class="fa fa-plus"></i>', ['value' => Url::to(['special', 'id' => $model->id]), 'title' => Yii::t('app', 'اضف تخصص'), 'class' => 'btn btn-flat bg-blue showModalButton']); ?>
        <?php //echo Html::button('<i class="fa fa-plus"></i>', ['value' => Url::to(['physician/add']), 'title' => Yii::t('app', 'اضف طبيب'), 'class' => 'btn btn-flat bg-blue showModalButton']); ?>
        <div class="col-lg-12 eArLangCss">
            <table class="table table-bordered table-responsive">
                <tr class="<?=$model->color?>">
                  <th style="color: white;"></th>
                  <th style="color: white;"><?= Yii::t('app', 'التخصص')?></th>
                  <th style="color: white;"><?= Yii::t('app', 'الطبيب')?></th>
                  <th style="color: white;"><?= Yii::t('app', 'رقم الهاتف')?></th>
                </tr>
                  <?php 
                    $specialization = $model->specializations;
                    foreach ($specialization as $i => $s) {
                
                  ?>
                  <td><?=  $i+1  ?></td>
                  <td><?= $s->specialty?></td>
                  <td><?= $s->doctor->name ?></td>
                  <td><?= $s->doctor->contact_no ?></td>
                  
                  
                </tr>
                  <?php } 

                  ?>
            </table>
        </div>
    </div>

    
</div>

    <?php Html::img($model->getPhoto($model->photo.$model->id),['alt'=>'No Image', 'class'=>'img-circle']); ?>

    
</div>
