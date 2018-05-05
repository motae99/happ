<?php 
use yii\helpers\Html;
use app\models\SystemAccount;
use dosamigos\chartjs\ChartJs;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = Yii::t('app', 'الخدمات اﻻعلان');
$this->params['breadcrumbs'][] = $this->title;


?> 


<div>
    <h1> </h1>
    <div class="col-lg-6 eArLangCss">
        <?= Html::button('<i class="fa fa-plus"></i>', ['value' => Url::to(['service']), 'title' => Yii::t('app', 'اضف خدمة'), 'class' => 'btn btn-flat bg-maroon showModalButton']); ?>

        <table class="table table-bordered table-responsive">
            <tr class="bg-maroon">
              <th style="color: white;"></th>
              <th style="color: white;"><?= Yii::t('app', 'اسم الخدمة')?></th>
              <th style="color: white;"><?= Yii::t('app', 'الوصف')?></th>
              
            </tr>
              <?php 
                foreach ($services as $i => $service) {
              ?>
              <td><?=  $i+1  ?></td>
              <td><?= $service->name?></td>
              <td><?= $service->description ?></td>
            </tr>
              <?php } 

              ?>
        </table>
    </div>

    <div class="col-lg-6 eArLangCss">
        <?= Html::button('<i class="fa fa-plus"></i>', ['value' => Url::to(['ads']), 'title' => Yii::t('app', 'اضف الاعلان'), 'class' => 'btn btn-flat bg-purple showModalButton']); ?>

        <table class="table table-bordered table-responsive">
            <tr class="bg-purple">
              <th style="color: white;"></th>
              <th style="color: white;"><?= Yii::t('app', 'الاعلان')?></th>
              <th style="color: white;"><?= Yii::t('app', 'الصورة')?></th>
              
            </tr>
              <?php 
                foreach ($ads as $i => $ad) {
              ?>
              <td><?=  $i+1  ?></td>
              <td><?= $ad->data?></td>
              <td><a href="<?= Yii::getAlias('@web').$ad->img ?>"><?= $ad->img ?></a> </td>
            </tr>
              <?php } 

              ?>
        </table>
    </div>

    <div class="col-lg-12 eArLangCss">

        <table class="table table-bordered table-responsive">
            <tr class="bg-olive">
              <th style="color: white;"></th>
              <th style="color: white;"><?= Yii::t('app', 'الخدمة')?></th>
              <th style="color: white;"><?= Yii::t('app', 'طالب الخدمة')?></th>
              <th style="color: white;"><?= Yii::t('app', 'رقم الهاتف')?></th>
              <th style="color: white;"><?= Yii::t('app', 'وصف الطلب')?></th>
              <th style="color: white;"><?= Yii::t('app', 'عنان العميل')?></th>
              <th style="color: white;"><?= Yii::t('app', 'وقت الطلب')?></th>
              <!-- <th style="color: white;"><?php // Yii::t('app', 'حالة الطلب')?></th>
              <th style="color: white;"><?php // Yii::t('app', 'الصورة')?></th> -->
              
            </tr>
              <?php 
                foreach ($requests as $i => $r) {
              ?>
              <td><?=  $i+1  ?></td>
              <td><?= $r->ser->name?></td>
              <td><?= $r->name?></td>
              <td><?= $r->phone?></td>
              <td><?= $r->address?></td>
              <td><?= $r->description?></td>
              <td><?= $r->created_at?></td>
            </tr>
              <?php } 

              ?>
        </table>
    </div>



</div>