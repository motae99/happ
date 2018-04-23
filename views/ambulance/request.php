<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ambulance */


?>
<div class="ambulance-requests">

    <h1> </h1>

    <div class="col-lg-12 eArLangCss">
        
            <table class="table table-bordered table-responsive">
                <tr class="bg-purple">
                  <th style="color: white;"></th>
                  <th style="color: white;"><?= Yii::t('app', 'شركة الاسعاف')?></th>
                  <th style="color: white;"><?= Yii::t('app', 'مكان الطب')?></th>
                  <th style="color: white;"><?= Yii::t('app', 'وجهة الطلب')?></th>
                  <th style="color: white;"><?= Yii::t('app', 'هاتف طالب الخدمة')?></th>
                  <th style="color: white;"><?= Yii::t('app', 'وقت الطلب')?></th>
                  <th style="color: white;"><?= Yii::t('app', 'حالة الطلب')?></th>
                </tr>
                  <?php 
                    foreach ($model as $i => $m) {
                  ?>
                  <td><?=  $i+1  ?></td>
                  <td><?= $m->ambulance->name?></td>
                  <td><?= $m->from_location ?></td>
                  <td><?= $m->to_location ?></td>
                  <td><?= $m->phone_no ?></td>
                  <td><?= $m->requested_at ?></td>
                  <td><?= $m->status ?></td>
                </tr>
                  <?php } 

                  ?>
            </table>
        </div>

</div>
