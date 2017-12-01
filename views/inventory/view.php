<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;


/* @var $this yii\web\View */
/* @var $model app\models\Inventory */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Inventories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-view">

    <h1></h1>

    <p>
        
        <?= Html::button('<i class="fa fa-plus"> New Invoice</i>', ['value' => Url::to(['invoices/create', 'id' => $model->id]), 'title' => 'Invoice', 'class' => 'btn btn-flat bg-green showModalButton']); ?>
        
    </p>

    <?php 
        $dataProvider =  new ActiveDataProvider([
            'query' => \app\models\Stock::find(),
            // 'sort'=> ['defaultOrder' => ['date'=>SORT_DESC, 'account_id'=>SORT_ASC, 'timestamp'=>SORT_ASC]],

        ]);
        $dataProvider->query->where(['inventory_id'=>$model->id])->all();

       $gridColumns  = 
        [   
            [ 
                'class'=>'kartik\grid\ExpandRowColumn',
                'width'=>'50px',
                'value'=>function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail'=>function ($model, $key, $index, $column) {
                    return Yii::$app->controller->renderPartial('_stocking', ['model'=>$model]);
                },
                'group'=>false, 
                // 'subGroupOf'=>7,
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'expandOneOnly'=>true
            ],
            [
                'attribute'=>'product_name',
                'header'=> 'Product',
                'width'=>'16%',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',
            ],
            [
                'class'=>'kartik\grid\DataColumn',
                'header'=> 'Sold',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                // 'width'=>'15%',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                    return $model->out($model); 
                                      
                },
                // 'contentOptions' => function ($model, $key, $index, $column) {
                //     $active = $model->product->active;
                //     if ($active == "percentage") {
                //         return ['style' => 'color:green; font-weight: bold;' ];
                //     }
                    
                // },
            ],
            [
                'class'=>'kartik\grid\DataColumn',
                'header'=> 'Transfered',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                // 'width'=>'15%',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                    return $model->trans($model);                    
                },
                'contentOptions' => function ($model, $key, $index, $column) {
                    $active = $model->product->active;
                    if ($active == "percentage") {
                        return ['style' => 'color:green; font-weight: bold;' ];
                    }
                    
                },
            ],
            [
                'class'=>'kartik\grid\DataColumn',
                'header'=> 'Available',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                // 'width'=>'15%',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                    return $model->in($model);                    
                },
                'contentOptions' => function ($model, $key, $index, $column) {
                    $active = $model->product->active;
                    if ($active == "percentage") {
                        return ['style' => 'color:green; font-weight: bold;' ];
                    }
                    
                },
            ],
            
            [
                'class'=>'kartik\grid\DataColumn',
                'header'=> 'AVG Cost',
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
                       $rate = $current_rate; 
                    }
                    return round($model->avg_cost*$rate, 2);                    
                },
            ],
            [
                'header'=>'Highest Rate',
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
                'hAlign'=>'center',
                'vAlign'=>'center',
            ],
            [  
                'class'=>'kartik\grid\FormulaColumn',
                'header'=>'Stock Value',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'format'=>['decimal', 2],
                'mergeHeader'=>true, 
                // 'width'=>'9%',
                'hAlign'=>'center', 
                'vAlign'=>'center',
                'value'=>function ($model, $key, $index, $widget) { 
                    $p = compact('model', 'key', 'index');
                    return $widget->col(4, $p) * $widget->col(5, $p) ;
                },
                
                'pageSummary'=>true,
                'footer'=>true 
            ],
            [  
                'class'=>'kartik\grid\FormulaColumn',
                'header'=>'Gross Sale',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'format'=>['decimal', 2],
                'mergeHeader'=>true, 
                // 'width'=>'9%',
                'hAlign'=>'center', 
                'vAlign'=>'center',
                'value'=>function ($model, $key, $index, $widget) { 
                    $p = compact('model', 'key', 'index');
                    $price = $model->product->selling_price;
                    return $widget->col(4, $p) * $widget->col(6, $p) * $price;
                },
                
                'pageSummary'=>true,
                'footer'=>true 
            ],
            [  
                'class'=>'kartik\grid\FormulaColumn',
                'header'=>'Margin Profit',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'format'=>['decimal', 2],
                'mergeHeader'=>true, 
                // 'width'=>'9%',
                'hAlign'=>'center', 
                'vAlign'=>'center',
                'value'=>function ($model, $key, $index, $widget) { 
                    $p = compact('model', 'key', 'index');
                    return $widget->col(8, $p)-$widget->col(7, $p);
                },
                
                'pageSummary'=>true,
                'footer'=>true 
            ],
            [   
                //only for testing
                'class'=>'kartik\grid\DataColumn',
                'header'=> 'quantity',
                // 'width'=>'15%',
                'value'=>function ($model, $key, $index, $widget) { 
                    return 0;
                },
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                'group'=>'true',
                //only for testing
            ],
            

        ]

    ?>
    <?php echo  GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => $gridColumns,

        'rowOptions' => function ($model) {
            $min = \app\models\Minimal::find()->where(['stock_id' => $model->id])->one();
            if ($min) {
                return ['class' => 'danger'];
            }
        },
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
        //     'heading' => '<i class="fa  fa-hospital-o"></i><strong>       Stock</strong>',

        // ],
        
    ]); ?>
</div>


</div>
