<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\StockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Stocks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-index">

    <h1></h1>
    <?php 
    $gridColumns  = 
        [   
               
            [
                'class'=>'kartik\grid\DataColumn',
                'attribute'=> 'inventory_id',
                'header'=> 'Inventory',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                'width'=>'13%',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                    return $model->inventory->name;                    
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(\app\models\Inventory::find()->orderBy('name')->asArray()->all(), 'id', 'name'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Name'],
                'group'=>true,
                'groupFooter'=>function ($model, $key, $index, $widget) { 
                        return [
                           'mergeColumns'=>[[4,7]],
                            'content'=>[             
                                0=>'total inventory items : ',
                                1=>GridView::F_COUNT,
                                2=>GridView::F_COUNT,
                                3=>GridView::F_SUM,
                                8=>GridView::F_SUM,
                             ],
                            'contentFormats'=>[      
                                1=>['format'=>'number'],
                                2=>['format'=>'number'],
                                3=>['format'=>'number'],
                                8=>['format'=>'number'],
                            ],
                            'contentOptions'=>[      
                                0=>['style'=>'font-variant:small-caps'],
                                1=>['style'=>'text-align:center'],
                                2=>['style'=>'text-align:center'],
                                3=>['style'=>'text-align:center'],
                                8=>['style'=>'text-align:center'],
                        ],

                            'options'=>['class'=>'success','style'=>'font-weight:bold;']
                        ];
                   },
            ],
            [
                'class'=>'kartik\grid\DataColumn',
                'attribute'=> 'category',
                'header'=> 'Category',
                'width'=>'13%',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                    return $model->product->category->name;                    
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(\app\models\Category::find()->orderBy('name')->asArray()->all(), 'id', 'name'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Name'],
                'group'=>true, 
                'subGroupOf'=>0,
                'groupFooter'=>function ($model, $key, $index, $widget) { 
                    return [
                       'mergeColumns'=>[[4, 7]], 
                        'content'=>[             
                            1=>'total category items : ',
                            2=>GridView::F_COUNT,
                            3=>GridView::F_SUM,
                            8=>GridView::F_SUM,
                         ],
                        'contentFormats'=>[      
                            2=>['format'=>'number'],
                            3=>['format'=>'number'],
                            8=>['format'=>'number'],
                        ],
                        'contentOptions'=>[      
                            1=>['style'=>'font-variant:small-caps'],
                            2=>['style'=>'text-align:center'],
                            3=>['style'=>'text-align:center'],
                            8=>['style'=>'text-align:center'],
                        ],
                        'options'=>['class'=>'info','style'=>'font-weight:bold;']
                    ];
                },   
            ],
            [
                'attribute'=>'product_name',
                'header'=> 'Product',
                'width'=>'16%',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                'footer'=>true 
            ],
            [   
                'attribute'=>'quantity',
                'header'=> 'Quantity',
                'width'=>'11%',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                'pageSummary'=>true,
                'footer'=>true
            ],
            [
                'class'=>'kartik\grid\DataColumn',
                'header'=> 'Buying Price',
                'width'=>'11%',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',   
                // 'width'=>'15%',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                    $current_rate = Yii::$app->mycomponent->rate();
                    if ($current_rate > $model->highest_rate) {
                        $rate = $current_rate;
                    }else{
                       $rate = $model->highest_rate; 
                    }
                    return $model->product->buying_price*$rate;                    
                },
            ],
            [
                'class'=>'kartik\grid\DataColumn',
                'header'=> 'Selling Price',
                'width'=>'11%',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                    $current_rate = Yii::$app->mycomponent->rate();
                    if ($current_rate > $model->highest_rate) {
                        $rate = $current_rate;
                    }else{
                       $rate = $model->highest_rate; 
                    }
                    return round($model->product->selling_price*$rate);                    
                },
               'contentOptions' => function ($model, $key, $index, $column) {
                    $active = $model->product->active;
                    if ($active == 'selling_price') {
                        return ['style' => 'color:green; font-weight: bold;' ];
                    }
                    
                },
            ],
            [
                'class'=>'kartik\grid\DataColumn',
                'attribute'=> 'Margin Profit',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                // 'width'=>'15%',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                    return $model->product->percentage."%";                    
                },
                'contentOptions' => function ($model, $key, $index, $column) {
                    $active = $model->product->active;
                    if ($active == "percentage") {
                        return ['style' => 'color:green; font-weight: bold;' ];
                    }
                    
                },
            ],
            [
                'header'=>'Active Rate',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                    $current_rate = Yii::$app->mycomponent->rate();
                    if ($current_rate > $model->highest_rate) {
                        $rate = $current_rate;
                    }else{
                       $rate = $model->highest_rate; 
                    }
                    return $rate;                    
                },
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'mergeHeader'=>true,
                'hAlign'=>'center',
                'vAlign'=>'top',
            ],
            [  
                'class'=>'kartik\grid\FormulaColumn',
                'header'=>'Total',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'format'=>['decimal', 2],
                // 'width'=>'9%',
                'mergeHeader'=>true,
                'hAlign'=>'center',
                'vAlign'=>'top',
                'value'=>function ($model, $key, $index, $widget) { 
                    $p = compact('model', 'key', 'index');
                    return $widget->col(3, $p) * $widget->col(5, $p);
                },
                
                'pageSummary'=>true,
                'footer'=>true 
            ],
        ]

    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'rowOptions' => function ($model) {
            $min = \app\models\Minimal::find()->where(['stock_id' => $model->id])->one();
            if ($min) {
                return ['class' => 'danger'];
            }
        },
        'toolbar' =>  [
            ['content'=>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'تحديث'])
            ],
            '{export}',
            '{toggleData}',
        ],
        'pjax' => true,
        'pjaxSettings'=>[
          'neverTimeout'=>true,
            'options'=>
              [
                'id'=>'Stock',
              ],
        ],
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'responsiveWrap' => true,
        'hover' => true,
        'floatHeader' => true,
       // 'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
        'showPageSummary' => true,
        // 'panel' => [
        //     'type' => GridView::TYPE_INFO,
        //     'heading' => '<i class="fa  fa-hospital-o"></i><strong></strong>',

        // ],
        
    ]); ?>
</div>
