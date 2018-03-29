<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ClinicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Clinics');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clinic-index">

    <h1></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Clinic'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php
    $gridColumns  = 
    [   
        [
            'class'=>'kartik\grid\DataColumn',
            'attribute'=>'city', 
            // 'width'=>'2px',
            'group'=>true,  // enable grouping
            'groupedRow'=>true,                    
            'groupOddCssClass'=>'kv-grouped-row',  
            'groupEvenCssClass'=>'kv-grouped-row',
            // 'groupFooter'=>function ($model, $key, $index, $widget) { 
            //     return [
            //         'mergeColumns'=>[[3,8]], 
            //         'content'=>[             // content to show in each summary cell
            //             1=> $model->city ,
            //             // 2=>GridView::F_COUNT,
            //         ],
            //         // 'contentFormats'=>[      // content reformatting for each summary cell
            //         //     4=>['format'=>'number', 'decimals'=>2],
            //         // ],
            //         'contentOptions'=>[      // content html attributes for each summary cell
            //             1=>['style'=>'font-variant:small-caps'],
            //             // 2=>['style'=>'text-align:center'],
            //         ],
            //         'options'=>['class'=>'bg-purple','style'=>'font-weight:bold;']
            //     ];
            // }
                
        ],  
           
        [
            'class'=>'kartik\grid\DataColumn',
            'attribute'=> 'type',
            'header'=> Yii::t('app', 'النوع') ,
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            'hAlign'=>'center',
            'vAlign'=>'center',
            'width'=>'15%',
            'format' => 'raw',
            'value' =>function ($model, $key, $index, $widget) { 
                return $model->type;                    
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(\app\models\Clinic::find()->orderBy('type')->asArray()->all(), 'type', 'type'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Type'],
            'group'=>true,
            'subGroupOf'=>0,
            'groupFooter'=>function ($model, $key, $index, $widget) { 
                return [
                   'mergeColumns'=>[[3,8]],
                    'content'=>[             
                        1=>$model->type.' - '.$model->city,
                        // 1=>GridView::F_COUNT,
                        2=>GridView::F_COUNT,
                        // 3=>GridView::F_SUM,
                        // 8=>GridView::F_SUM,
                     ],
                    'contentFormats'=>[      
                        // 1=>['format'=>'number'],
                        2=>['format'=>'number'],
                        // 3=>['format'=>'number'],
                        // 8=>['format'=>'number'],
                    ],
                    'contentOptions'=>[      
                        0=>['style'=>'font-variant:small-caps'],
                        // 1=>['style'=>'text-align:center'],
                        2=>['style'=>'text-align:center'],
                        // 3=>['style'=>'text-align:center'],
                        // 8=>['style'=>'text-align:center'],
                ],

                    'options'=>['class'=>'bg-purple','style'=>'font-weight:bold;']
                ];
            },
        ],
        [
            'class'=>'kartik\grid\DataColumn',
            'attribute'=> 'name',
            'header'=> Yii::t('app', 'الأسم') ,
            'width'=>'10%',
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            // 'mergeHeader'=>true,
            'hAlign'=>'center',
            'vAlign'=>'center', 
            'format' => 'raw',
            'value' =>function ($model, $key, $index, $widget) { 
                return $model->name;                    
            },
        ],
        
        [
            'attribute'=>'address',
            'header'=> Yii::t('app', 'العنوان'),
            'width'=>'20%',
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            'hAlign'=>'center',
            'vAlign'=>'center',
            'footer'=>true 
        ],
        [
            'attribute'=>'primary_contact',
            'header'=> Yii::t('app', 'هاتف'),
            'width'=>'10%',
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            'hAlign'=>'center',
            'vAlign'=>'center',
            'footer'=>true 
        ],
        
        [
            'attribute'=>'working_days',
            'header'=> Yii::t('app', 'أيام العمل'),
            'width'=>'23%',
            // 'headerOptions'=>['class'=>'kartik-sheet-style'],
            'hAlign'=>'center',
            'vAlign'=>'center',
            'footer'=>true 
        ],
        [
            'header'=> Yii::t('app', 'ساعات الدوام'),
            // 'headerOptions'=>['class'=>'kartik-sheet-style'],
            'width'=>'12%',
            'hAlign'=>'center',
            'vAlign'=>'center',
            'value' =>function ($model, $key, $index, $widget) { 
                return $model->start.' - '.$model->end;                    
            },
        ],
        [   
            'attribute'=>'app_service',
            'header'=> Yii::t('app', '?'),
            'width'=>'5%',
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            // 'mergeHeader'=>true,
            'format' => 'raw',
            'hAlign'=>'center',
            'vAlign'=>'center', 
            'value' =>function ($model, $key, $index, $widget) { 
                if ($model->app_service == 'yes') {
                    return "<i class='fa fa-2x fa-check-circle' style='color: green;'></i>  "; 
                }elseif ($model->app_service == 'no') {
                    return "<i class='fa fa-2x fa-times-circle' style='color: red;'></i>  "; 
                }
                                  
            },
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'header' => "",
            'width' => '5%',
            'template' => '{view} ',
        ],
    ]


?>
  <?php echo  GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
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
      // 'floatHeader' => true,
     // 'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
      'showPageSummary' => true,
      // 'panel' => [
      //     'type' => GridView::TYPE_INFO,
      //     'heading' => '<i class="fa  fa-hospital-o"></i><strong>       Stock</strong>',

      // ],
      
  ]); ?>
    <?php Pjax::end(); ?>
</div>
