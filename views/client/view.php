<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\mpdf\Pdf;


/* @var $this yii\web\View */
/* @var $model app\models\Client */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Clients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-view">
    <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('<i class="fa fa-print"></i>', ['pdf', 'id' => $model->id], [
            'class' => 'btn btn-flat bg-maroon']) 
        ?>

    <p> 
        <?= Html::button('<i class="fa fa-edit"></i>', ['value' => Url::to(['client/update', 'id' => $model->id]), 'title' => Yii::t('client', 'Update Client'), 'class' => 'btn btn-flat bg-aqua showModalButton']); ?>

        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="col-lg-6 eArLangCss">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'client_name',
                    'phone',
                    'address:ntext',
                    'account_id',
                ],
            ]) ?>
        </div>
        <div class="col-lg-6 eArLangCss">
            <table class="table-bordered table table-responsive">
            <tr>
                <td>Recivable</td>
                <td><?=round($model->recievable->balance, 2)?></td>
            </tr>
            <?php if ($model->payable) {?>
                    
            <tr>
                <td>payable</td>
                <td><?=round($model->payable->balance, 2)?></td>
            </tr>
            <?php }?>
            </table>
        </div>
    </div>
</div>

<div class="box box-info">
<?php 
// $pdf = Yii::$app->pdf; // or new Pdf();
// $mpdf = $pdf->api; // fetches mpdf api
// print_r($mpdf);
// $mpdf->SetHeader('Kartik Header'); // call methods or set any properties
// $mpdf->WriteHtml($mpdf); // call mpdf write html
// echo $mpdf->Output('filename', 'D'); // call the mpdf api output as needed
?>
</div>