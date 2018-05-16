<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;


$this->title = Yii::t('app', 'التقارير');
$this->params['breadcrumbs'][] = $this->title;

?>
<h1></h1>

    <?php echo $this->render('_reportsearch', ['model' => $searchModel]); ?>


  <?php 
            // $dataProvider =  new ActiveDataProvider([
            //     'query' => \app\models\Appointment::find(),
            //     // 'sort'=> ['defaultOrder' => ['date'=>SORT_DESC, 'account_id'=>SORT_ASC, 'timestamp'=>SORT_ASC]],

            // ]);
            // // $dataProvider->query->where(['physician_id'=>$model->id])->all();

            // $dataProvider = $dataProvider->query->andWhere(['date'=> date('Y-m-d')]);

           $gridColumns  = 
            [ 
              [ 
                'class'=>'kartik\grid\DataColumn',
                'attribute'=>'physician_id',
                'header'=> Yii::t('app', 'الطبيب'),
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'hAlign'=>'center',
                    'vAlign'=>'center',
                    'width'=>'12%',
                    'format' => 'raw',
                    'value' =>function ($model, $key, $index, $widget) { 
                        return $model->doctor->name; 
                                          
                    },
                  'group'=>true,
                  'groupFooter'=>function ($model, $key, $index, $widget) { 
                      return [
                         'mergeColumns'=>[[0, 1],[5,10],],
                          'content'=>[             
                              0=>' المجموع ',
                              2=>GridView::F_COUNT,
                              5=>GridView::F_SUM,
                           ],
                          'contentFormats'=>[      
                              2=>['format'=>'number'],
                              5=>['format'=>'number'],
                          ],
                          'contentOptions'=>[      
                              0=>['style'=>'font-variant:small-caps'],
                              2=>['style'=>'text-align:center'],
                              5=>['style'=>'text-align:center'],
                      ],

                          'options'=>['class'=>$model->clinic->color,'style'=>'font-weight:bold;']
                      ];
                  },
              ], 
              [
                'header'=> Yii::t('app', 'يوم'),
                'attribute'=>'date',
                'width'=>'10%',
                'group'=>true,
                'subGroupOf'=>0,
                  'groupFooter'=>function ($model, $key, $index, $widget) { 
                      return [
                         'mergeColumns'=>[[3,4], [6, 10]],
                          'content'=>[             
                              1=>'يوم '.$model->date,
                              2=>GridView::F_COUNT,
                              5=>GridView::F_SUM,
                           ],
                          'contentFormats'=>[      
                              2=>['format'=>'number'],
                              5=>['format'=>'number'],
                          ],
                          'contentOptions'=>[      
                              1=>['style'=>'font-variant:small-caps'],
                              2=>['style'=>'text-align:center'],
                              5=>['style'=>'text-align:center'],
                      ],

                          'options'=>['class'=>'bg-navy','style'=>'font-weight:bold;']
                      ];
                  },
              ],
              [
                'class'=>'kartik\grid\DataColumn',
                'header'=> 'اسم المريض',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'attribute'=>'patientName',
                'width'=>'16%',
                'hAlign'=>'center',
                'vAlign'=>'center',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                  if ($model->patient->gender == 'male') {
                    $gender = Html::tag('i', '', ['class' => 'fa fa-male', 'style'=>"color: blue;"]);
                  }elseif($model->patient->gender == 'female'){
                    $gender = Html::tag('i', '', ['class' => 'fa fa-female', 'style'=>"color: blue;"]);
                  }else{
                    $gender = Html::tag('i', '', ['class' => 'fa fa-transgender', 'style'=>"color: blue;"]);
                  }
                  
                    return $model->patientName.'  /  '.$model->age.' Y '.$gender; 
                                      
                },
              ],
              [
                'class'=>'kartik\grid\DataColumn',
                'header'=> 'هاتف المريض',
                'attribute'=>'patientPhone',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                'width'=>'10%',
                'format' => 'raw',
              ],
              [ 
                'attribute'=>'provider',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'header'=> Yii::t('app', 'تأمين'),
                'hAlign'=>'center',
                'vAlign'=>'center',
                'width'=>'16%',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                    if ($model->insured == 'yes') {
                      return "<i class='fa fa-check-circle-o' style='color: green' ></i>  ".$model->patient->provider->name." # ".$model->patient->insurance_no;
                    }elseif ($model->insured == 'no') {
                      return "<i class='fa fa-times-circle-o' style='color: red'></i>  "; 
                    }
                                      
                },
                    // 'contentOptions' => function ($model, $key, $index, $column) {
                    //    if ($model->insured == 'yes') {
                    //      return ['style' => 'color:green;' ];
                    //     }elseif ($model->insured == 'no') {
                    //      return ['style' => 'color:red;' ];
                    //     }
                        
                    // },
              ],  
              [  
                'class'=>'kartik\grid\DataColumn',
                'header'=> Yii::t('app', 'رسوم الحجز'),
                'attribute'=>'fee',
                'width' => '5%',                
                'format' => 'raw',
                    'value' =>function ($model, $key, $index, $widget) { 
                        if ($model->insured == 'yes') {
                          return $model->insured_fee;
                        }elseif ($model->insured == 'no') {
                          return $model->fee;
                        }
                                          
                    },
                'pageSummary'=>true,
                'footer'=>true
              ],
              
              // [
              //   'header'=> Yii::t('app', 'الزمن'),
              //   'width'=>'8%',
              //   // 'attribute'=>'time',
              //   'value' =>function ($model, $key, $index, $widget) { 
              //     return $model->time;
              //   }
              // ],
              [
                'header'=> Yii::t('app', 'وقت الحجز'),
                'attribute'=>'created_at',
                'width'=>'13%',

              ],
              [
                'header'=> Yii::t('app', 'وقت تأكيد الحجز'),
                'attribute'=>'confirmed_at',
                'width'=>'13%',
              ],
              // [
              //   // 'header'=> Yii::t('app', 'الترتيب'),
              //   'attribute'=>'queue',
              //   'width'=>'3%',
              //   'hiddenFromExport' => true,
                
              //   // 'value' =>function ($model, $key, $index, $widget) { 
              //   //   return $model->queue;
              //   // }
              // ],
              // [
              //   'header'=> Yii::t('app', ''),
              //   'hiddenFromExport' => true,
              //   // 'attribute'=>'status',
              //   'headerOptions'=>['class'=>'kartik-sheet-style'],
              //   'hAlign'=>'center',
              //   'vAlign'=>'center',
              //   'width'=>'3%',
              //   'format' => 'raw',
              //   'value' =>function ($model, $key, $index, $widget) { 
              //     if($model->status == 'confirmed'){
              //       return Html::tag('span', '', ['class' => 'fa fa-calendar-check-o']);
              //     }elseif($model->status == 'booked'){
              //       return Html::a('<span class="fa fa-calendar-o"></span>', ['pay', 'id'=> $model->id] , [
              //         'title' => 'تأكيد', 'method' => 'post'
              //       ]);
              //     }else{
              //       return Html::tag('span', '', ['class' => 'fa fa-calendar-times-o']);
              //     }
              //   },
              //   'contentOptions' => function ($model, $key, $index, $column) {
              //       if ($model->status == 'confirmed') {
              //         return ['style' => 'color:green;' ];
              //       }elseif ($model->status == 'booked') {
              //         return ['style' => 'color:orange;' ];
              //       }else{
              //         return ['style' => 'color:red;' ];
              //       }
                      
              //     },
              // ], 
              [
                'header'=> Yii::t('app', ''),
                'hiddenFromExport' => true,
                // 'attribute'=>'stat',
                'vAlign'=>'center',
                'width'=>'5%',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                  if($model->stat == 'done'){
                    return Html::tag('span', '', ['class' => 'fa fa-check-circle-o', 'style'=>"color: green;"]);
                  }elseif($model->status == 'booked'){
                    return Html::tag('span', '', ['class' => 'fa fa-minus', 'style'=>"color: red;"]);
                  }elseif($model->stat == 'schadueled'){
                    return Html::a('<span class="fa fa-hourglass-2" style="color: orange;"></span>', ['proccess', 'id'=> $model->id] , [
                      'title' => 'مقابلة', 'method' => 'post'
                    ]);
                  }elseif($model->stat == 'processing'){
                    return Html::a('<span class="fa fa-clock-o" style="color: blue;"></span>', ['finish', 'id'=> $model->id], [
                      'title' => 'تم', 'method' => 'post'
                    ]);
                  }
                },
                'contentOptions' => function ($model, $key, $index, $column) {
                  if ($model->stat == 'done') {
                    return ['style' => 'color:green;' ];
                  }elseif ($model->stat == 'schadueled') {
                    return ['style' => 'color:orange;' ];
                  }elseif($model->stat == 'processing'){
                    return ['style' => 'color:red;' ];
                  }
                    
                },
              ],
              [
                'header'=> Yii::t('app', ''),
                // 'headerOptions'=>['class'=>'fa fa-2x fa-mobile', 'style' => "color: blue;"],
                'hiddenFromExport' => true,

                // 'attribute'=>'paiedTo',
                'vAlign'=>'center',
                'hAlign'=>'center',
                'width'=>'5%',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                  if($model->paiedTo == 'app'){
                    return Html::tag('span', '', ['class' => 'glyphicon glyphicon-phone', 'style'=>"color: blue;"]);
                  }elseif($model->paiedTo == 'registers'){
                    return Html::tag('span', '', ['class' => 'fa fa-money', 'style'=>"color: green;"]);
                  }
                  else{
                    return Html::tag('span', '', ['class' => 'fa  fa-minus', 'style'=>"color: red;"]);
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
              // [
              //   'header'=> Yii::t('app', ''),
              //   'headerOptions'=>['class'=>'fa fa-2x fa-times-circle-o', 'style' => "color: red;"],
              //   'hiddenFromExport' => true,
              //   'vAlign'=>'center',
              //   'hAlign'=>'center',
              //   'width'=>'3%',
              //   'format' => 'raw',
              //   'value' =>function ($model, $key, $index, $widget) { 
              //     if(($model->stat == 'done') || ($model->stat == 'processing')){
              //       return Html::tag('span', '', ['class' => 'fa fa-check-circle-o', 'style'=>"color: green;"]);
              //     }elseif($model->stat == 'canceled'){
              //       return Html::tag('span', '', ['class' => 'fa fa-times-circle-o', 'style'=>"color: orange;"]);
              //     }else{
              //       return Html::a('<span class="fa fa-times-circle-o" style="color: red;"></span>', ['cancel', 'id'=> $model->id] , [
              //         'title' => 'الغاء', 'method' => 'get'
              //       ]);
              //     }
              //     // elseif($model->stat == 'schadueled'){
              //     //   return Html::a('<span class="fa fa-hourglass-2" style="color: orange;"></span>', ['proccess', 'id'=> $model->id] , [
              //     //     'title' => 'مقابلة', 'method' => 'post'
              //     //   ]);
              //     // }elseif($model->stat == 'processing'){
              //     //   return Html::a('<span class="fa fa-clock-o" style="color: blue;"></span>', ['finish', 'id'=> $model->id], [
              //     //     'title' => 'تم', 'method' => 'post'
              //     //   ]);
              //     // }
              //   },
                
              // ], 
 
            ]

  ?>
  <?php echo  GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => $gridColumns,
      'export' => [
          'fontAwesome' => true
      ],

      // 'rowOptions' => function ($model) {
      //     $min = \app\models\Minimal::find()->where(['stock_id' => $model->id])->one();
      //     if ($min) {
      //         return ['class' => 'danger'];
      //     }
      // },
      'exportConfig' => [ 
          GridView::PDF => [
              'fontAwesome' => true,
              'label' => Yii::t('app', 'Type PDF'),
              'icon' => 'fa fa-hospital-o',
              'iconOptions' => ['class' => 'text-danger'],
              'showHeader' => true,
              'showPageSummary' => true,
              'showFooter' => true,
              'showCaption' => true,
              'filename' => Yii::t('app', 'filename'),
              'alertMsg' => Yii::t('app', 'Its downloading, Wait for it.'),
              // 'options' => ['title' => Yii::t('app', 'Portable Document Format')],
              'mime' => 'application/pdf',
              'config' => [
                  // 'mode' => 'c',
                  'format' => 'A4-L',
                  'destination' => 'D',
                  'marginTop' => 20,
                  'marginBottom' => 20,
                // 'cssFile' => '@web/css/ar/AdminLTE-rtl.css',
                'cssInline' => 'body { direction: rtl; font-family: Jannat; } th { text-align: right; } td { text-align: right;}',
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
                  // 'SetWatermarkImage' => [
                  //     // Yii::$app->mycomponent->logo(),
                  //     0.1, 
                  //     [100,100],
                  // ],
                  // 'SetAuthor' => [
                  //     'Motae',
                  // ],
                  // 'SetCreator' => [
                  //     'System Name',
                  // ],
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
              'id'=>'Reports',
            ],
        // 'beforeGrid'=> echo $this->render('_search', ['model' => $searchModel]),
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
      'panel' => [
          'type' => GridView::TYPE_INFO,
          'heading' => '<i class="fa  fa-2x fa-heartbeat"></i><strong>    </strong>',

      ],
      // set export properties

      // 'toolbar' => [
      //   'content'=> [
      //       Html::button('<i class="glyphicon glyphicon-plus"></i>', [
      //           'type'=>'button', 
      //           'title'=>Yii::t('kvgrid', 'Add Book'), 
      //           'class'=>'btn btn-success'
      //       ]) . ' '.
      //       Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['grid-demo'], [
      //           'class' => 'btn btn-default', 
      //           'title' => Yii::t('kvgrid', 'Reset Grid')
      //       ]),
      //       'options' => ['class' => 'btn-group-sm']
      //     ],
      //     '{export}',
      //     '{toggleData}'
      // ],
      // 'toggleDataContainer' => ['class' => 'btn-group-sm'],
      // 'exportContainer' => ['class' => 'btn-group-sm']
      
      
  ]); ?>