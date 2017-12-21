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
    $dataProvider->query->where(['client_id' => $model->id])->all();

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
        [
            'class'=>'kartik\grid\DataColumn',
            'attribute'=>'date',
            'header'=> Yii::t('invo', 'Date'),
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            'hAlign'=>'center',
            'group'=>true,
            'width'=>'15%',
            // 'format' => 'date',
        ],
        [
            'class'=>'kartik\grid\DataColumn',
            'attribute'=>'id',
            'header'=> Yii::t('invo', '#NO'),
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            'hAlign'=>'center',
            // 'group'=>true,
            'width'=>'8%',
            'format' => 'raw',
        ],
        [
            'class'=>'kartik\grid\DataColumn',
            'attribute'=>'amount',
            'header'=> Yii::t('invo', 'Total'),
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            'hAlign'=>'center',
            'width'=>'20%',
            'format' => 'raw',
            'pageSummary'=> true,
        ],
        [  
            'class'=>'kartik\grid\FormulaColumn',
            'header'=>Yii::t('invo', 'Total Paid'),
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            // 'format'=>['decimal', 2],
            // 'mergeHeader'=>true, 
            'width'=>'20%',
            'hAlign'=>'center', 
            'value'=>function ($model, $key, $index, $widget) { 
                return $model->totalPaid ;
            },
            'pageSummary'=>true,
            'footer'=>true 
        ],
        [  
            'class'=>'kartik\grid\FormulaColumn',
            'header'=> Yii::t('invo', 'Remaining'),
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            // 'format'=>['decimal', 2],
            'width'=>'20%',
            'mergeHeader'=>true,
            'hAlign'=>'center',
            'vAlign'=>'center',
            'value'=>function ($model, $key, $index, $widget) { 
                $p = compact('model', 'key', 'index');
                return $widget->col(3, $p) - $widget->col(4, $p);
            },
            'pageSummary'=>true,
            'footer'=>true 
        ],
        [
            'class'=>'kartik\grid\DataColumn',
            'header'=> Yii::t('invo', 'Status'),
            'headerOptions'=>['class'=>'skip-export'],
            'contentOptions'=>['class'=>'skip-export'],
            'footerOptions'=>['class'=>'skip-export'],
            'pageSummaryOptions'=>['class'=>'skip-export'],
            'hAlign'=>'center',
            'width'=>'10%',
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
        [
            'class' => 'kartik\grid\DataColumn',
            'headerOptions'=>['class'=>'skip-export'],
            'contentOptions'=>['class'=>'skip-export'],
            'footerOptions'=>['class'=>'skip-export'],
            'pageSummaryOptions'=>['class'=>'skip-export'],
            'mergeHeader'=>true, 
            'format' => 'raw',
            'width'=>'10%',
            'value' =>function ($model, $key, $index, $widget) { 
                return  Html::a('<i class="fa fa-search"></i>', ['invoices/view', 'id' => $model->id], ['class' => '']); 
            },
            'footer'=>false,
            'pageSummary'=>false,
        ],
        // [
        //     'class' => 'kartik\grid\DataColumn',
        //     'headerOptions'=>['class'=>'skip-export'],
        //     'contentOptions'=>['class'=>'skip-export'],
        //     'footerOptions'=>['class'=>'skip-export'],
        //     'pageSummaryOptions'=>['class'=>'skip-export'],
        //     'format' => 'raw',
        //     'width'=>'5%',
        //     'value' =>function ($model, $key, $index, $widget) { 
        //         return Html::button('<i class="fa fa-print"></i>', ['value' => Url::to(['invoices/print', 'id' => $model->id]), 'title' => Yii::t('client', 'Update Client'), 'class' => 'btn btn-flat bg-aqua']);
        //         // return  Html::a('<i class="fa fa-print"></i>', ['invoices/print', 'id' => $model->id], ['class' => '']); 
        //     },
        //     'footer'=>false,
        //     'pageSummary'=>false,
        // ],
    ];

?>

<?=  GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            $invoice = \app\models\Invoices::find()->where(['id' => $model->id])->one();
            if ($invoice->status == 'paid') {
                return ['class' => 'success'];
            }elseif ($invoice->status == 'partially') {
                return ['class' => 'info'];
            }else{
                return ['class' => 'danger'];
            }
        },
        'toolbar' =>  [
            ['content'=>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'تحديث'])
            ],
            'export' => [
                'export' => true,
                'icon' => 'floppy-disk',
            ],
            '{export}',
            '{toggleData}',
        ],
        'exportConfig' => [ 
            GridView::PDF => [
                'label' => Yii::t('app', 'Type PDF'),
                'icon' => 'floppy-disk',
                'iconOptions' => ['class' => 'text-danger'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                // 'filename' => $model->client_name,
                'alertMsg' => Yii::t('app', 'Its downloading, Wait for it.'),
                // 'options' => ['title' => Yii::t('app', 'Portable Document Format')],
                'mime' => 'application/pdf',
                'config' => [
                    // 'mode' => 'c',
                    'format' => 'A4-L',
                    'destination' => 'I',
                    'marginTop' => 20,
                    'marginBottom' => 20,
                  // 'cssFile' => '@web/css/ar/bootstrap-rtl.min.css',
                  'cssInline' => 'body { direction: rtl; font-family: Alarabiya; font-size: large;} th { text-align: right; } td { text-align: right;}',
                  'methods' => [
                    'SetHeader' => [
                        [
                        'odd' => [
                                'L' => [
                                  'content' => Yii::$app->mycomponent->name(),
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
                        Yii::$app->mycomponent->logo(),
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
                    // 'WriteBarcode' => [
                    //     '978095422461',
                    // ],
                  ],
                  // 'options' => [
                  //   'title' => 'Preceptors',
                  //   'subject' => 'Preceptors',
                  //   'keywords' => 'pdf, preceptors, export, other, keywords, here'
                  // ],
                ]
            ],
        ],
        'panel' => [
            'type' => GridView::TYPE_INFO,
            'heading' => '<i class="fa fa-user "></i>',

        ],
        'pjax' => true,
        'pjaxSettings'=>[
          'neverTimeout'=>true,
            'options'=>
              [
                'id'=>'ClientInvoices',
              ],
        ],
        // 'bordered' => false,
        'striped' => false,
        'condensed' => true,
        'responsive' => true,
        'responsiveWrap' => true,
        'hover' => true,
        'showPageSummary' => true,
        // 'pageSummaryOptions'=>['class'=>'info'],
        'columns' => $gridColumns,
    ]); 
?>