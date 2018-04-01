<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
?>

<div >
        <?php 
            $dataProvider =  new ActiveDataProvider([
                'query' => \app\models\Availability::find(),
                // 'sort'=> ['defaultOrder' => ['date'=>SORT_DESC, 'account_id'=>SORT_ASC, 'timestamp'=>SORT_ASC]],

            ]);
            $dataProvider->query->where(['physician_id'=>$model->id])->all();

           $gridColumns  = 
            [	
            	 [ 
                    'class'=>'kartik\grid\ExpandRowColumn',
                    'width'=>'50px',
                    'value'=>function ($model, $key, $index, $column) {
                        return GridView::ROW_COLLAPSED;
                    },
                    'detail'=>function ($model, $key, $index, $column) {
                        return Yii::$app->controller->renderPartial('_inner', ['model'=>$model]);
                    },
                    // 'group'=>false, 
                    // 'subGroupOf'=>7,
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'expandOneOnly'=>true
                ],
            	[
                    'class'=>'kartik\grid\DataColumn',
                    'header'=> Yii::t('app', 'العيادة'),
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'hAlign'=>'center',
                    'vAlign'=>'center',
                    // 'width'=>'8%',
                    'format' => 'raw',
                    'value' =>function ($model, $key, $index, $widget) { 
                        return $model->clinic->name; 
                                          
                    },
                    
                ], 
            	[
            		'attribute'=>'date',
            		'header'=> Yii::t('app', 'أيام العمل'),
            	], 
            	[
            		'attribute'=>'from_time',
            		'header'=> Yii::t('app', 'بدأ العمل'),
            	], 
            	[
            		'attribute'=>'to_time',
            		'header'=> Yii::t('app', 'انتهاء العمل'),
            	], 
            	[
            		'attribute'=>'appointment_fee',
            		'header'=> Yii::t('app', 'رسوم المقابله'),
            	], 
            	[
            		'attribute'=>'revisiting_fee',
            		'header'=> Yii::t('app', 'رسوم المتابعه'),
            	],
            	[
            		'attribute'=>'max',
            		'header'=> Yii::t('app', 'عدد المقابﻻت'),
            	],  
            	[	
                    'class'=>'kartik\grid\DataColumn',
            		'header'=> Yii::t('app', '?'),
            		'format' => 'raw',
                    'value' =>function ($model, $key, $index, $widget) { 
                        if ($model->status == 'available') {
	                        return "<i class='fa fa-2x fa-check-circle'></i>  "; 
                        }elseif ($model->status == 'canceled') {
	                        return "<i class='fa fa-2x fa-check'></i>  "; 
                        }
                                          
                    },
                    'contentOptions' => function ($model, $key, $index, $column) {
                       if ($model->status == 'available') {
                        	return ['style' => 'color:green;' ];
                        }elseif ($model->status == 'canceled') {
                        	return ['style' => 'color:red;' ];
                        }
                        
                    },
            	], 
                // [ 
                //     'class'=>'kartik\grid\ExpandRowColumn',
                //     'width'=>'50px',
                //     'value'=>function ($model, $key, $index, $column) {
                //         return GridView::ROW_COLLAPSED;
                //     },
                //     'detail'=>function ($model, $key, $index, $column) {
                //         return Yii::$app->controller->renderPartial('_stocking', ['model'=>$model]);
                //     },
                //     // 'group'=>false, 
                //     // 'subGroupOf'=>7,
                //     'headerOptions'=>['class'=>'kartik-sheet-style'],
                //     'expandOneOnly'=>true
                // ],
                // [
                //     'attribute'=>'product_name',
                //     'header'=> Yii::t('inventory', 'Item'),
                //     'width'=>'25%',
                //     'headerOptions'=>['class'=>'kartik-sheet-style'],
                //     'hAlign'=>'center',
                //     'vAlign'=>'center',
                // ],
                // [
                //     'class'=>'kartik\grid\DataColumn',
                //     'header'=> Yii::t('inventory', 'Sold'),
                //     'headerOptions'=>['class'=>'kartik-sheet-style'],
                //     'hAlign'=>'center',
                //     'vAlign'=>'center',
                //     'width'=>'8%',
                //     'format' => 'raw',
                //     'value' =>function ($model, $key, $index, $widget) { 
                //         return "<i class='fa fa-caret-up'></i>  ".Yii::$app->formatter->asDecimal($model->out($model)); 
                                          
                //     },
                //     'contentOptions' => function ($model, $key, $index, $column) {
                //         return ['style' => 'color:green; font-weight: bold;' ];
                        
                //     },
                // ],
                // [
                //     'class'=>'kartik\grid\DataColumn',
                //     'header'=> Yii::t('inventory', 'Transfered'),
                //     'headerOptions'=>['class'=>'kartik-sheet-style'],
                //     'hAlign'=>'center',
                //     'vAlign'=>'center',
                //     'width'=>'8%',
                //     'format' => 'raw',
                //     'value' =>function ($model, $key, $index, $widget) { 
                //         return "<i class='fa fa-caret-left'></i>  ".Yii::$app->formatter->asDecimal($model->trans($model));                    
                //     },
                //     'contentOptions' => function ($model, $key, $index, $column) {
                //         return ['style' => 'color:orange; font-weight: bold;' ];
                        
                //     },
                // ],
                // [
                //     'class'=>'kartik\grid\DataColumn',
                //     'header'=> Yii::t('inventory', 'Returned'),
                //     'headerOptions'=>['class'=>'kartik-sheet-style'],
                //     'hAlign'=>'center',
                //     'vAlign'=>'center',
                //     'width'=>'8%',
                //     'format' => 'raw',
                //     'value' =>function ($model, $key, $index, $widget) { 
                //         return "<i class='fa fa-caret-down'></i>  ".Yii::$app->formatter->asDecimal($model->returned($model));                    
                //     },
                //     'contentOptions' => function ($model, $key, $index, $column) {
                //         return ['style' => 'color:red; font-weight: bold;' ];
                //     },
                // ],
                // [
                //     'class'=>'kartik\grid\DataColumn',
                //     'header'=> Yii::t('inventory', 'Available'),
                //     'headerOptions'=>['class'=>'kartik-sheet-style'],
                //     'hAlign'=>'center',
                //     'vAlign'=>'center',
                //     'width'=>'8%',
                //     'format'=>['decimal'],
                //     'value' =>function ($model, $key, $index, $widget) { 
                //         return $model->returned($model)+$model->in($model);                    
                //     },
                //     // 'contentOptions' => function ($model, $key, $index, $column) {
                //     //     return ['style' => 'color:red; font-weight: bold;' ];
                //     // },
                // ],
                
                // [
                //     'class'=>'kartik\grid\DataColumn',
                //     'header'=> Yii::t('inventory', 'AVG Cost'),
                //     'headerOptions'=>['class'=>'kartik-sheet-style'],
                //     'hAlign'=>'center',
                //     'vAlign'=>'center',   
                //     'width'=>'8%',
                //     'format'=>['decimal'],
                //     'value' =>function ($model, $key, $index, $widget) { 
                //         $current_rate = Yii::$app->mycomponent->rate();
                //         return round($model->avg_cost*$current_rate, 3);                    
                //     },
                // ],
                // [
                //     'header'=> Yii::t('inventory', 'Highest Rate'),
                //     'format'=>['decimal'],
                //     'width'=>'8%',
                //     'value' =>function ($model, $key, $index, $widget) { 
                //         $current_rate = Yii::$app->mycomponent->rate();
                //         if ($current_rate > $model->highest_rate) {
                //             $rate = $current_rate;
                //         }else{
                //            $rate = $model->highest_rate; 
                //         }
                //         return $rate;                    
                //     },
                //     'headerOptions'=>['class'=>'kartik-sheet-style'],
                //     'hAlign'=>'center',
                //     'vAlign'=>'center',
                // ],
                // [  
                //     'class'=>'kartik\grid\FormulaColumn',
                //     'header'=> Yii::t('inventory', 'Stock Value'),
                //     'headerOptions'=>['class'=>'kartik-sheet-style'],
                //     'format'=>['decimal'],
                //     'mergeHeader'=>true, 
                //     'width'=>'10%',
                //     'hAlign'=>'center', 
                //     'vAlign'=>'center',
                //     'value'=>function ($model, $key, $index, $widget) { 
                //         $p = compact('model', 'key', 'index');
                //         return $widget->col(5, $p) * $widget->col(6, $p) ;
                //     },
                    
                //     'pageSummary'=>true,
                //     'footer'=>true 
                // ],
                // [  
                //     'class'=>'kartik\grid\FormulaColumn',
                //     'header'=> Yii::t('inventory', 'Gross Sale'),
                //     'headerOptions'=>['class'=>'kartik-sheet-style'],
                //     'format'=>['decimal'],
                //     'mergeHeader'=>true, 
                //     'width'=>'10%',
                //     'hAlign'=>'center', 
                //     'vAlign'=>'center',
                //     'value'=>function ($model, $key, $index, $widget) { 
                //         $p = compact('model', 'key', 'index');
                //         $price = $model->product->selling_price;
                //         return $widget->col(5, $p) * $widget->col(7, $p) * $price;
                //     },
                    
                //     'pageSummary'=>true,
                //     'footer'=>true 
                // ],
                // [  
                //     'class'=>'kartik\grid\FormulaColumn',
                //     'header'=> Yii::t('inventory', 'Margin Profit'),
                //     'headerOptions'=>['class'=>'kartik-sheet-style'],
                //     'format'=>['decimal'],
                //     'mergeHeader'=>true, 
                //     'width'=>'10%',
                //     'hAlign'=>'center', 
                //     'vAlign'=>'center',
                //     'value'=>function ($model, $key, $index, $widget) { 
                //         $p = compact('model', 'key', 'index');
                //         return $widget->col(9, $p)-$widget->col(8, $p);
                //     },
                    
                //     'pageSummary'=>true,
                //     'footer'=>true 
                // ],
            ]

        ?>
        <?php echo  GridView::widget([
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'columns' => $gridColumns,

            // 'rowOptions' => function ($model) {
            //     $min = \app\models\Minimal::find()->where(['stock_id' => $model->id])->one();
            //     if ($min) {
            //         return ['class' => 'danger'];
            //     }
            // },
            'exportConfig' => [ 
                GridView::PDF => [
                    'label' => Yii::t('app', 'Type PDF'),
                    'icon' => 'floppy-disk',
                    'iconOptions' => ['class' => 'text-danger'],
                    'showHeader' => true,
                    'showPageSummary' => true,
                    'showFooter' => true,
                    'showCaption' => true,
                    'filename' => Yii::t('app', 'Inventory'),
                    'alertMsg' => Yii::t('app', 'Its downloading, Wait for it.'),
                    // 'options' => ['title' => Yii::t('app', 'Portable Document Format')],
                    'mime' => 'application/pdf',
                    'config' => [
                        // 'mode' => 'c',
                        'format' => 'A4-L',
                        'destination' => 'D',
                        'marginTop' => 20,
                        'marginBottom' => 20,
                      // 'cssFile' => '@web/css/ar/bootstrap-rtl.min.css',
                      'cssInline' => 'body { direction: rtl; font-family: Jannat;} th { text-align: right; } td { text-align: right;}',
                      'methods' => [
                        'SetHeader' => [
                            [
                            'odd' => [
                                    'L' => [
                                      'content' => "blow", //Yii::$app->mycomponent->name(),
                                      'font-size' => 10,
                                      'font-style' => 'B',
                                      'font-family' => 'serif',
                                      'color'=>'#27292b'
                                    ],
                                    'C' => [
                                      'content' => 'Page - {PAGENO}/{nbpg}',
                                      'font-size' => 10,
                                      'font-style' => 'B',
                                      'font-family' => 'serif',
                                      'color'=>'#27292b'
                                    ],
                                    'R' => [ 
                                      'content' => 'Printed @ {DATE j-m-Y}',
                                      'font-size' => 10,
                                      'font-style' => 'B',
                                      'font-family' => 'serif',
                                      'color'=>'#27292b'
                                    ],
                                    'line' => 1,
                                ],
                                'even' => []
                            ]
                        ],
                        // 'SetFooter' => [
                        //     $arr,
                        // ],
                        // 'SetWatermarkText' => ['motae', 0.3],
                        'SetWatermarkImage' => [
                            // Yii::$app->mycomponent->logo(),
                            0.1, 
                            [100,100],
                        ],
                        'SetAuthor' => [
                            'Motae',
                        ],
                        'SetCreator' => [
                            'System Name',
                        ],
                        // 'SetProtection' => [
                        //     [],
                        //     'UserPassword',
                        //     'MyPassword',
                        // ],
                      
                      ],
                      
                    ]
                ],
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
            // 'floatHeader' => true,
           // 'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
            'showPageSummary' => true,
            // 'panel' => [
            //     'type' => GridView::TYPE_INFO,
            //     'heading' => '<i class="fa  fa-hospital-o"></i><strong>       Stock</strong>',

            // ],
            
        ]); ?>

    </div>