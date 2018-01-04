<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Clients');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">

    
    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('<i class="fa fa-plus"></i>', ['value' => Url::to(['client/create']), 'title' => Yii::t('client', 'Add New Client'), 'class' => 'btn btn-flat bg-blue showModalButton']); ?>

    </p>

    <?php 
        $arr = [
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
            ];
        $defaultExportConfig = [
            // GridView::HTML => [
            //     'label' => Yii::t('kvgrid', 'HTML'),
            //     'icon' => $isFa ? 'file-text' : 'floppy-saved',
            //     'iconOptions' => ['class' => 'text-info'],
            //     'showHeader' => true,
            //     'showPageSummary' => true,
            //     'showFooter' => true,
            //     'showCaption' => true,
            //     'filename' => Yii::t('kvgrid', 'grid-export'),
            //     'alertMsg' => Yii::t('kvgrid', 'The HTML export file will be generated for download.'),
            //     'options' => ['title' => Yii::t('kvgrid', 'Hyper Text Markup Language')],
            //     'mime' => 'text/html',
            //     'config' => [
            //         'cssFile' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'
            //     ]
            // ],
            // GridView::CSV => [
            //     'label' => Yii::t('kvgrid', 'CSV'),
            //     'icon' => $isFa ? 'file-code-o' : 'floppy-open', 
            //     'iconOptions' => ['class' => 'text-primary'],
            //     'showHeader' => true,
            //     'showPageSummary' => true,
            //     'showFooter' => true,
            //     'showCaption' => true,
            //     'filename' => Yii::t('kvgrid', 'grid-export'),
            //     'alertMsg' => Yii::t('kvgrid', 'The CSV export file will be generated for download.'),
            //     'options' => ['title' => Yii::t('kvgrid', 'Comma Separated Values')],
            //     'mime' => 'application/csv',
            //     'config' => [
            //         'colDelimiter' => ",",
            //         'rowDelimiter' => "\r\n",
            //     ]
            // ],
            // GridView::TEXT => [
            //     'label' => Yii::t('kvgrid', 'Text'),
            //     'icon' => $isFa ? 'file-text-o' : 'floppy-save',
            //     'iconOptions' => ['class' => 'text-muted'],
            //     'showHeader' => true,
            //     'showPageSummary' => true,
            //     'showFooter' => true,
            //     'showCaption' => true,
            //     'filename' => Yii::t('kvgrid', 'grid-export'),
            //     'alertMsg' => Yii::t('kvgrid', 'The TEXT export file will be generated for download.'),
            //     'options' => ['title' => Yii::t('kvgrid', 'Tab Delimited Text')],
            //     'mime' => 'text/plain',
            //     'config' => [
            //         'colDelimiter' => "\t",
            //         'rowDelimiter' => "\r\n",
            //     ]
            // ],
            // GridView::EXCEL => [
            //     'label' => Yii::t('kvgrid', 'Excel'),
            //     'icon' => $isFa ? 'file-excel-o' : 'floppy-remove',
            //     'iconOptions' => ['class' => 'text-success'],
            //     'showHeader' => true,
            //     'showPageSummary' => true,
            //     'showFooter' => true,
            //     'showCaption' => true,
            //     'filename' => Yii::t('kvgrid', 'grid-export'),
            //     'alertMsg' => Yii::t('kvgrid', 'The EXCEL export file will be generated for download.'),
            //     'options' => ['title' => Yii::t('kvgrid', 'Microsoft Excel 95+')],
            //     'mime' => 'application/vnd.ms-excel',
            //     'config' => [
            //         'worksheet' => Yii::t('kvgrid', 'ExportWorksheet'),
            //         'cssFile' => ''
            //     ]
            // ],
            GridView::PDF => [
                'label' => Yii::t('app', 'PDF'),
                'icon' => 'floppy-disk',
                'iconOptions' => ['class' => 'text-danger'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => Yii::t('app', 'grid-export'),
                'alertMsg' => Yii::t('app', 'The PDF export file will be generated for download.'),
                'options' => ['title' => Yii::t('app', 'Portable Document Format')],
                'mime' => 'application/pdf',
                'config' => [
                    'mode' => 'c',
                    'format' => 'A4-L',
                    'destination' => 'B',
                    'marginTop' => 20,
                    'marginBottom' => 20,
                    'cssInline' => '.kv-wrap{padding:20px;}' .
                        '.kv-align-center{text-align:center;}' .
                        '.kv-align-left{text-align:left;}' .
                        '.kv-align-right{text-align:right;}' .
                        '.kv-align-top{vertical-align:top!important;}' .
                        '.kv-align-bottom{vertical-align:bottom!important;}' .
                        '.kv-align-middle{vertical-align:middle!important;}' .
                        '.kv-page-summary{border-top:4px double #ddd;font-weight: bold;}' .
                        '.kv-table-footer{border-top:4px double #ddd;font-weight: bold;}' .
                        '.kv-table-caption{font-size:1.5em;padding:8px;border:1px solid #ddd;border-bottom:none;}',
                    'methods' => [
                        'SetHeader' => [
                            'odd' => '$pdfHeader',
                            'even' => '$pdfHeader'
                        ],
                        'SetFooter' => [
                            'odd' => '$pdfFooter', 
                            'even' => '$pdfFooter'
                        ],
                        'SetWatermarkText' => ['motae', 0.2],
                        'SetAuthor' => 'Motae',
                        'SetCreator' => 'System Name',
                    ],
                    // 'showWatermarkText' => true,
                    'options' => [
                        'title' => '$title',
                        'subject' => Yii::t('app', 'PDF export generated by kartik-v/yii2-grid extension'),
                        'keywords' => Yii::t('app', 'krajee, grid, export, yii2-grid, pdf')
                    ],
                    // 'showWatermarkText' => true,
                    'contentBefore'=>'',
                    'contentAfter'=>''
                ]
            ],
            // GridView::JSON => [
            //     'label' => Yii::t('kvgrid', 'JSON'),
            //     'icon' => $isFa ? 'file-code-o' : 'floppy-open',
            //     'iconOptions' => ['class' => 'text-warning'],
            //     'showHeader' => true,
            //     'showPageSummary' => true,
            //     'showFooter' => true,
            //     'showCaption' => true,
            //     'filename' => Yii::t('kvgrid', 'grid-export'),
            //     'alertMsg' => Yii::t('kvgrid', 'The JSON export file will be generated for download.'),
            //     'options' => ['title' => Yii::t('kvgrid', 'JavaScript Object Notation')],
            //     'mime' => 'application/json',
            //     'config' => [
            //         'colHeads' => [],
            //         'slugColHeads' => false,
            //         'jsonReplacer' => null,
            //         'indentSpace' => 4
            //     ]
            // ],
        ];
        $src = Yii::$app->mycomponent->logo();


    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
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
        /*'export' => [
            'PDF' => [
                'options' => [
                    'title' => 'Preceptors',
                    'subject' => 'Preceptors',
                    'author' => 'NYCSPrep CIMS',
                    'keywords' => 'NYCSPrep, preceptors, pdf'
                ]
            ],
        ],*/
        'exportConfig' => [ 
            GridView::PDF => [
                'label' => Yii::t('app', 'Type PDF'),
                'icon' => 'floppy-disk',
                'iconOptions' => ['class' => 'text-danger'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => Yii::t('app', 'Clients'),
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
                  'cssInline' => 'body { direction: rtl; font-family: Jannat;} th { text-align: right; } td { text-align: right;}',
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
        'pjax' => true,
        'pjaxSettings'=>[
          'neverTimeout'=>true,
            'options'=>
              [
                'id'=>'Clients',
              ],
        ],
        'bordered' => true,

        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'responsiveWrap' => true,
        'hover' => true,
        'showPageSummary' => true,
        'panel' => [
            'type' => GridView::TYPE_INFO,
            'heading' => '<i class="fa fa-users "></i><strong></strong>',

        ],
        'columns' => [
            [
                'class' => 'kartik\grid\DataColumn',
                'headerOptions'=>['class'=>'skip-export'],
                'contentOptions'=>['class'=>'skip-export'],
                'footerOptions'=>['class'=>'skip-export'],
                'pageSummaryOptions'=>['class'=>'skip-export'],
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                    return  Html::a('<i class="fa fa-search"></i>', ['view', 'id' => $model->id], ['class' => 'btn btn-flat '.$model->color_class.' ']); 
                },
                'footer'=>false,
                'pageSummary'=>false,
            ],
            'client_name',
            'phone',
            'address:ntext',
            [
                'class'=>'kartik\grid\DataColumn',
                'header'=> Yii::t('client', 'Invoices') ,
                // 'width'=>'11%',
                'format' => 'decimal',
                'headerOptions'=>['class'=>'kartik-sheet-style', ],
                'hAlign'=>'center',
                'vAlign'=>'center',   
                'value' =>function ($model, $key, $index, $widget) { 
                    return $model->invoicescount ;                    
                },
                'pageSummary'=>true,
                'footer'=>true
            ],
            [
                'class'=>'kartik\grid\DataColumn',
                'header'=> Yii::t('client', 'Opening Balance') ,
                // 'width'=>'11%',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',   
                'format' => 'decimal',
                'value' =>function ($model, $key, $index, $widget) { 
                    return round($model->recievable->opening_balance) ;                    
                },
            ],
            [
                'class'=>'kartik\grid\DataColumn',
                'header'=> Yii::t('client', 'Recievable') ,
                // 'width'=>'11%',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',   
                'format' => 'decimal',
                'value' =>function ($model, $key, $index, $widget) { 
                    return round($model->recievable->balance) ;                    
                },
                'pageSummary'=>true,
                'footer'=>true
            ],
            [
                'class'=>'kartik\grid\DataColumn',
                'header'=> Yii::t('client', 'Payable') ,
                // 'width'=>'11%',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',   
                'format' => 'decimal',
                'value' =>function ($model, $key, $index, $widget) { 
                    if ($model->payable) {
                        return round($model->payable->balance) ;                    
                    }else{
                        return 0;
                    }
                        
                },
                'pageSummary'=>true,
                'footer'=>true
            ],

            // ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    
</div>
