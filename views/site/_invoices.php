<?php 
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;

?>

<?php 
    $dataProvider =  new ActiveDataProvider([
            'query' => \app\models\Invoices::find(),
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC, ]],
            // 'pagination' => true,

        ]);
    $dataProvider->query->where(['date'=>date('Y-m-d')])->all();

    $gridColumns  = 
    [   
        [ 
            'class'=>'kartik\grid\ExpandRowColumn',
            'width'=>'5%',
            'value'=>function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail'=>function ($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('_invo', ['model'=>$model]);
            },
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            'expandOneOnly'=>true
        ],
        /*[
            // 'attribute'=>'inventory_id',
            'header'=> Yii::t('invo', 'checkMe'),
            // 'width'=>'26%',
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            'hAlign'=>'center',
            'value' =>function ($model, $key, $index, $widget) { 
                return $model->inventory->name;                    
                },
            'group'=>true,

        ],*/
        [
            'class'=>'kartik\grid\DataColumn',
            'attribute'=>'client_id',
            'header'=> Yii::t('invo', 'Client'),
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            'hAlign'=>'center',
            'group'=>true,
            // 'width'=>'26%',
            'format' => 'raw',
            'value' =>function ($model, $key, $index, $widget) { 
                return $model->client->client_name; 
                                  
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
            'attribute'=>'id',
            'header'=> Yii::t('invo', '#NO'),
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            'hAlign'=>'center',
            'group'=>true,
            'width'=>'8%',
            'format' => 'raw',
            // 'value' =>function ($model, $key, $index, $widget) { 
            //     return $model->client->client_name; 
                                  
            //     },

            // 'contentOptions' => function ($model, $key, $index, $column) {
            //     $active = $model->product->active;
            //     if ($active == "percentage") {
            //         return ['style' => 'color:green; font-weight: bold;' ];
            //     }
                
            // },
        ],
        [
            'class'=>'kartik\grid\DataColumn',
            'attribute'=>'cost',
            'header'=> Yii::t('invo', 'Cost'),
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            'hAlign'=>'center',
            'footer'=>true ,
            'pageSummary'=>true,
            'width'=>'10%',
            'format' => 'decimal',
            // 'value' =>function ($model, $key, $index, $widget) { 
            //     return $model->trans($model);                    
            // },
            // 'contentOptions' => function ($model, $key, $index, $column) {
            //     $active = $model->product->active;
            //     if ($active == "percentage") {
            //         return ['style' => 'color:green; font-weight: bold;' ];
            //     }
                
            // },
        ],
        [
            'class'=>'kartik\grid\DataColumn',
            'attribute'=>'amount',
            'header'=> Yii::t('invo', 'Total'),
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            'hAlign'=>'center',
            'width'=>'10%',
            'format' => 'decimal',
            'pageSummary'=> true,
           /* 'value' =>function ($model, $key, $index, $widget) { 
                return $model->in($model);                    
            },
            'contentOptions' => function ($model, $key, $index, $column) {
                $active = $model->product->active;
                if ($active == "percentage") {
                    return ['style' => 'color:green; font-weight: bold;' ];
                }
                
            },*/
        ],
        [  
            'class'=>'kartik\grid\FormulaColumn',
            'header'=>Yii::t('invo', 'Gross Sale'),
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            'format' => 'decimal',
            'mergeHeader'=>true, 
            'width'=>'10%',
            'hAlign'=>'center', 
            'value'=>function ($model, $key, $index, $widget) { 
                $p = compact('model', 'key', 'index');
                return $widget->col(4, $p) - $widget->col(3, $p) ;
            },
            
            'pageSummary'=>true,
            'footer'=>true 
        ],
        [
            'class'=>'kartik\grid\DataColumn',
            'attribute'=>'status',
            'header'=> Yii::t('invo', 'Status'),
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            'hAlign'=>'center',
            'width'=>'5%',
            'format' => 'raw',
            'value' =>function ($model, $key, $index, $widget) { 
                if ($model->status == "paid") {
                    return '<i class="fa fa-check-circle" style="color: green;"></i>';
                }elseif($model->status == "partially"){
                    return '<i class="fa fa-minus-circle" style="color: orange;"></i>';
                }else{
                    return '<i class="fa fa-times-circle" style="color: red;"></i>';
                }
                                  
            },
        ],
        // [
        //     'class' => 'kartik\grid\ActionColumn',
        //     'header' => Yii::t('invo', 'View'),
        //     'width' => '5%',
        //     'template' => '{view} ',
        //     // 'viewOptions'=>['lable'=>'<i class="glyphicon glyphicon-remove"></i>'],
        //     // 'updateOptions'=>['null' => true],
        //     // 'deleteOptions'=>['null' => true],
        // ],
    ];

?>

<?=  GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'pjax' => true,
        'pjaxSettings'=>[
          'neverTimeout'=>true,
            'options'=>
              [
                'id'=>'Invoices',
              ],
        ],
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'responsiveWrap' => true,
        'hover' => true,
        'showPageSummary' => true,
        
    ]); 
?>