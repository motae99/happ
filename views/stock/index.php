<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\StockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Stocks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-index" style="direction: rtl;">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Stock'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            [
                'attribute'=>  'phar_id',
                'header' => 'اسم الصيدلية',
                'value' =>function ($model, $key, $index, $widget) { 
                    return $model->phar->name;                    
                },
            ],
            [
                'attribute'=>  'sup_id',
                'header' => 'اسم المورد',
                'value' =>function ($model, $key, $index, $widget) { 
                    return $model->sup->name;                    
                },
            ],
            [
                'attribute'=>  'drug_id',
                'header' => 'اسم الدواء',
                'value' =>function ($model, $key, $index, $widget) { 
                    return $model->drug->product_name;                    
                },
            ],
            'quantity',
            'buying_price',
            'selling_price',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
