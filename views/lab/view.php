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
            'logitude:ntext',
            'latitude:ntext',
            'phone',
            'secondary_phone',
            'rate',

            ],
        ]) 
    ?>
    </div>
    
    <div class="col-lg-6 eArLangCss">
        <?= Html::button('<i class="fa fa-plus"></i>', ['value' => Url::to(['exam', 'id' => $model->id]), 'title' => Yii::t('app', 'اضف فحص'), 'class' => 'btn btn-flat bg-maroon showModalButton']); ?>
        <div class="col-lg-12 eArLangCss">
            <table class="table table-bordered table-responsive">
                <tr class="bg-navy">
                  <th style="color: white;"></th>
                  <th style="color: white;"><?= Yii::t('app', 'اسم الفحص')?></th>
                  <th style="color: white;"><?= Yii::t('app', 'السعر الفحص')?></th>
                  <th style="color: white;"><?= Yii::t('app', 'الوصف')?></th>
                  <th style="color: white;"><?= Yii::t('app', 'تسليم النتيجة')?></th>
                </tr>
                  <?php 
                    $exams = $model->exam;
                    foreach ($exams as $i => $e) {
                
                  ?>
                  <td><?=  $i+1  ?></td>
                  <td><?= $e->name?></td>
                  <td><?= $e->price ?></td>
                  <td><?= $e->description ?></td>
                  <td><?= $e->resault ?></td>
                </tr>
                  <?php } 

                  ?>
            </table>
        </div>

        <div class="col-lg-12 eArLangCss">
        <?= Html::button('<i class="fa fa-plus"></i>', ['value' => Url::to(['insu', 'id' => $model->id]), 'title' => Yii::t('app', 'اضف تأمين'), 'class' => 'btn btn-flat bg-blue showModalButton']); ?>

            <table class="table table-bordered table-responsive">
                <tr class="bg-purple">
                  <th style="color: white;"></th>
                  <th style="color: white;"><?= Yii::t('app', 'شركة التأمين')?></th>
                  <th style="color: white;"><?= Yii::t('app', 'قيمة التخفيض')?></th>
                </tr>
                  <?php 
                    $labin = $model->labin;
                    foreach ($labin as $i => $in) {
                
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