<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pharmacy */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pharmacies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pharmacy-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
       
    </p>
<div class="row">
    <div class="col-lg-6 eArLangCss">
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'state',
            'city',
            'address:ntext',
            'working_days:ntext',
            'from_hour',
            'to_hour',
            'app_service',
            'logitude:ntext',
            'latitude:ntext',
            'phone',
            'rate',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
        ]) ?>
    </div>
    
    <div class="col-lg-6 eArLangCss">
        <?= Html::button('<i class="fa fa-plus"></i>', ['value' => Url::to(['drug', 'id' => $model->id]), 'title' => Yii::t('app', 'اضف منتج'), 'class' => 'btn btn-flat bg-purple showModalButton']); ?>
        <div class="col-lg-12 eArLangCss">
            <table class="table table-bordered table-responsive">
                <tr class="bg-navy">
                  <th style="color: white;"></th>
                  <th style="color: white;"><?= Yii::t('app', 'اسم المنتج')?></th>
                  <th style="color: white;"><?= Yii::t('app', 'رقم المنتج')?></th>
                  <th style="color: white;"><?= Yii::t('app', 'وصف المنتج')?></th>
                  <th style="color: white;"><?= Yii::t('app', 'الكمية المتوفر')?></th>
                  <th style="color: white;"><?= Yii::t('app', 'السعر')?></th>
                </tr>
                  <?php 
                    $drugs = $model->drugs;
                    foreach ($drugs as $i => $d) {
                
                  ?>
                  <td><?=  $i+1  ?></td>
                  <td><?= $d->product_name?></td>
                  <td><?= $d->no ?></td>
                  <td><?= $d->description ?></td>
                  <td><?= $d->quantity ?></td>
                  <td><?= $d->price ?></td>
                </tr>
                  <?php } 

                  ?>
            </table>
        </div>

        <div class="col-lg-12 eArLangCss">
        <?= Html::button('<i class="fa fa-plus"></i>', ['value' => Url::to(['insu', 'id' => $model->id]), 'title' => Yii::t('app', 'اضف تأمين'), 'class' => 'btn btn-flat bg-blue showModalButton']); ?>

            <table class="table table-bordered table-responsive">
                <tr class="bg-navy">
                  <th style="color: white;"></th>
                  <th style="color: white;"><?= Yii::t('app', 'شركة التأمين')?></th>
                  <th style="color: white;"><?= Yii::t('app', 'قيمة التخفيض')?></th>
                </tr>
                  <?php 
                    $pharin = $model->pharin;
                    foreach ($pharin as $i => $in) {
                
                  ?>
                  <td><?=  $i+1  ?></td>
                  <td><?= $in->insurance->name?></td>
                  <td><?= $in->discount ?></td>
                </tr>
                  <?php } 

                  ?>
            </table>
        </div>
    </div>
</div>

</div>

