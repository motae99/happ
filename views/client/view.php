<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\mpdf\Pdf;


/* @var $this yii\web\View */
/* @var $model app\models\Client */

$this->title = $model->client_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Clients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-view">
    <h1><?php //echo Html::encode($this->title) ?></h1>



    
    <div class="row">
        <div class="col-lg-4 eArLangCss">

            <div class="col-lg-12 eArLangCss">
                <p> 
                    <?= Html::a('<i class="fa fa-print"></i>', ['pdf', 'id' => $model->id], [
                        'class' => 'btn btn-flat bg-maroon']) 
                    ?>
                    <?= Html::button('<i class="fa fa-edit"></i>', ['value' => Url::to(['client/update', 'id' => $model->id]), 'title' => Yii::t('client', 'Update Client'), 'class' => 'btn btn-flat bg-aqua showModalButton']); ?>
                    
                </p>
                <?php 
                    if ($model->recievable->opening_balance > 0) {
                        echo $this->render('clearbalance', ['model'=>$model]);
                    }
                ?>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        // 'id',
                        'client_name',
                        'phone',
                        'address:ntext',
                        // 'account_id',
                    ],
                ]) ?>
            </div>
            <div class="col-lg-12 eArLangCss">
                <?php if ($model->payable) {?>
                   <div class="col-lg-6 eArLangCss">
                    <div class="small-box bg-green">
                        <div class="inner">
                          <h3><?= Yii::$app->formatter->asDecimal(round($model->recievable->balance, 2)) ?><sup style="font-size: 20px">$</sup></h3>

                          <h4><?= Yii::t('app', 'Recivable') ?></h4>
                        </div>
                        <div class="icon">
                          <i class="fa fa-arrow-circle-down"></i>
                        </div>
                        <a href="#" class="small-box-footer"> <i class="fa fa-arrow-circle-down"></i></a>
                    </div>
                   </div>     
                   <div class="col-lg-6 eArLangCss">
                    <div class="small-box bg-red">
                        <div class="inner">
                          <h3><?=Yii::$app->formatter->asDecimal(round($model->payable->balance, 2)) ?><sup style="font-size: 20px">$</sup></h3>

                          <h4><?= Yii::t('app', 'Payable') ?></h4>
                        </div>
                        <div class="icon">
                          <i class="fa fa-arrow-circle-up"></i>
                        </div>
                        <a href="#" class="small-box-footer"> <i class="fa fa-arrow-circle-up"></i></a>
                    </div>
                   </div>     
                
                <?php }else {?>
                    <div class="col-lg-12 eArLangCss">
                        <div class="small-box bg-green">
                            <div class="inner">
                              <h3><?=Yii::$app->formatter->asDecimal(round($model->recievable->balance, 2)) ?><sup style="font-size: 20px">$</sup></h3>

                              <h4><?= Yii::t('app', 'Recivable') ?></h4>
                            </div>
                            <div class="icon">
                              <i class="fa fa-arrow-circle-down"></i>
                            </div>
                            <a href="#" class="small-box-footer"> <i class="fa fa-arrow-circle-down"></i></a>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
        <div class="col-lg-8 eArLangCss">
        <?php echo $this->render('clientinvoices', ['model'=>$model]);?>
        </div>
    </div>
</div>

