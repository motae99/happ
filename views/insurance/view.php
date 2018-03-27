<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
?>

  <?php 
            $dataProvider =  new ActiveDataProvider([
                'query' => \app\models\Appointment::find(),
                // 'sort'=> ['defaultOrder' => ['date'=>SORT_DESC, 'account_id'=>SORT_ASC, 'timestamp'=>SORT_ASC]],

            ]);
            $dataProvider->query->where(['insured'=>'yes'])->all();

           $gridColumns  = 
            [   
                [   
                    'class'=>'kartik\grid\DataColumn',
                    'attribute'=>'clinic_id',
                    'header'=> Yii::t('app', 'المرفق'),
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'hAlign'=>'center',
                    'vAlign'=>'center',
                    // 'width'=>'8%',
                    'format' => 'raw',
                    'value' =>function ($model, $key, $index, $widget) { 
                        return $model->clinic->name; 
                                          
                    },
                  'group'=>true,
                  'groupFooter'=>function ($model, $key, $index, $widget) { 
                      return [
                         'mergeColumns'=>[[0,1],[2,3],[6,10],],
                          'content'=>[             
                              0=>Yii::t('app', ' المجموع '),
                              2=>GridView::F_COUNT,
                              4=>GridView::F_SUM,
                              5=>GridView::F_SUM,
                              6=>GridView::F_SUM,
                           ],
                          'contentFormats'=>[      
                              2=>['format'=>'number'],
                              4=>['format'=>'number'],
                              5=>['format'=>'number'],
                              6=>['format'=>'number'],
                          ],
                          'contentOptions'=>[      
                              0=>['style'=>'font-variant:small-caps'],
                              2=>['style'=>'text-align:center'],
                              4=>['style'=>'text-align:center'],
                              5=>['style'=>'text-align:center'],
                              6=>['style'=>'text-align:center'],
                      ],

                          'options'=>['class'=>$model->clinic->color,'style'=>'font-weight:bold;']
                      ];
                 },
                ], 
                [   
                    'class'=>'kartik\grid\DataColumn',
                    'attribute'=>'physician_id',
                    'header'=> Yii::t('app', 'طبيب'),
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'hAlign'=>'center',
                    'vAlign'=>'center',
                    // 'width'=>'8%',
                    'format' => 'raw',
                    'value' =>function ($model, $key, $index, $widget) { 
                        return $model->doctor->name; 
                                          
                    },
                 //  'group'=>true,

                 //  'groupFooter'=>function ($model, $key, $index, $widget) { 
                 //      return [
                 //         'mergeColumns'=>[[3,10],],
                 //          'content'=>[             
                 //              0=>Yii::t('app', ' المجموع '),
                 //              1=>GridView::F_COUNT,
                 //              2=>GridView::F_SUM,
                 //           ],
                 //          'contentFormats'=>[      
                 //              2=>['format'=>'number'],
                 //              1=>['format'=>'number'],
                 //          ],
                 //          'contentOptions'=>[      
                 //              0=>['style'=>'font-variant:small-caps'],
                 //              1=>['style'=>'text-align:center'],
                 //              2=>['style'=>'text-align:center'],
                 //      ],

                 //          'options'=>['class'=>$model->clinic->color,'style'=>'font-weight:bold;']
                 //      ];
                 // },
                ], 
                [
                    'class'=>'kartik\grid\DataColumn',
                    'header'=> Yii::t('app', 'المريض'),
                    'attribute'=>'physician_id',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'hAlign'=>'center',
                    'vAlign'=>'center',
                    // 'width'=>'8%',
                    'format' => 'raw',
                    'value' =>function ($model, $key, $index, $widget) { 
                        return $model->patient->name; 
                                          
                    },
                ],
                [
                    'class'=>'kartik\grid\DataColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'header'=> Yii::t('app', 'رقم التأمين'),
                    'attribute'=>'insured_fee',
                    'hAlign'=>'center',
                    'vAlign'=>'center',
                    // 'width'=>'8%',
                    'format' => 'raw',
                    'value' =>function ($model, $key, $index, $widget) { 
                        if ($model->insured == 'yes') {
                            return   $model->patient->insurance_no; 
                        }elseif ($model->insured == 'no') {
                            return "<i class='fa fa-2x fa-times'></i>  "; 
                        }
                                          
                    },
                    'contentOptions' => function ($model, $key, $index, $column) {
                       if ($model->insured == 'no') {
                            return ['style' => 'color:red;' ];
                        }
                        
                    },
                ], 
                [   
                    'class'=>'kartik\grid\DataColumn',
                    'header'=> Yii::t('app', 'رسوم الحجز'),
                    'attribute'=>'fee',
                    'pageSummary'=>true,
                    'footer'=>true
                ],
                [   
                    'class'=>'kartik\grid\DataColumn',
                    'header'=> Yii::t('app', 'المدفوع'),
                    'attribute'=>'insured_fee',
                    'pageSummary'=>true,
                    'footer'=>true
                ], 
                [
                    'class'=>'kartik\grid\DataColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'header'=> Yii::t('app', 'استحقاق الطبيب'),
                    'attribute'=>'insured_fee',
                    'hAlign'=>'center',
                    'vAlign'=>'center',
                    // 'width'=>'8%',
                    'format' => 'raw',
                    'value' =>function ($model, $key, $index, $widget) { 
                        $accept = $model->insu( $model->availability_id);                                    
                        return $accept->insurance_refund;
                    },
                    'pageSummary'=>true,
                    'footer'=>true
                ],
                
        
                [
                    'header'=> Yii::t('app', 'حالة الحجز'),
                    'attribute'=>'status',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'hAlign'=>'center',
                    'vAlign'=>'center',
                    // 'width'=>'8%',
                    'format' => 'raw',
                    'value' =>function ($model, $key, $index, $widget) { 
                      if($model->status == 'confirmed'){
                              return Html::tag('span', '', ['class' => 'fa fa-2x fa-calendar-check-o']);
                            }elseif($model->status == 'booked'){
                            return Html::a('<span class="fa fa-2x fa-calendar-o"></span>', ['register/pay', 'id'=> $model->id] , [
                              'title' => 'تأكيد', 'method' => 'post'
                            ]);
                          }else{
                        return Html::tag('span', '', ['class' => 'fa fa-2x fa-calendar-times-o']);
                      }
                    },
                    'contentOptions' => function ($model, $key, $index, $column) {
                        if ($model->status == 'confirmed') {
                          return ['style' => 'color:green;' ];
                        }elseif ($model->status == 'booked') {
                          return ['style' => 'color:orange;' ];
                        }else{
                          return ['style' => 'color:red;' ];
                        }
                          
                      },

                ], 
                [
                    'header'=> Yii::t('app', 'الموقف'),
                    'attribute'=>'stat',
                    'vAlign'=>'center',
                    // 'width'=>'8%',
                    'format' => 'raw',
                    'value' =>function ($model, $key, $index, $widget) { 
                      if($model->stat == 'done'){
                        return Html::tag('span', '', ['class' => 'fa fa-2x fa-check-circle-o', 'style'=>"color: green;"]);
                      }elseif($model->stat == 'schadueled'){
                        return Html::a('<span class="fa fa-2x fa-hourglass-2" style="color: orange;"></span>', ['register/proccess', 'id'=> $model->id] , [
                          'title' => 'مقابلة', 'method' => 'post'
                        ]);
                      }elseif($model->stat == 'processing'){
                        return Html::a('<span class="fa fa-2x fa-clock-o" style="color: blue;"></span>', ['register/finish', 'id'=> $model->id], [
                          'title' => 'تم', 'method' => 'post'
                        ]);
                      }
                    },
                // 'contentOptions' => function ($model, $key, $index, $column) {
                //   if ($model->stat == 'done') {
                //     return ['style' => 'color:green;' ];
                //   }elseif ($model->stat == 'schadueled') {
                //     return ['style' => 'color:orange;' ];
                //   }elseif($model->stat == 'processing'){
                //     return ['style' => 'color:red;' ];
                //   }
                    
                // },
                ], 
                [
                    'header'=> Yii::t('app', 'وقت الحجز'),
                    'attribute'=>'created_at',
                ],
                [
                    'header'=> Yii::t('app', 'وقت التأكيد'),
                    'attribute'=>'confirmed_at',
                ],  
 
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
              'id'=>'Register',
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