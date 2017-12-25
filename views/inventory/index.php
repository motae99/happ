<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;

use app\models\Inventory;
/* @var $this yii\web\View */
/* @var $searchModel app\models\InventorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('inventory', 'Inventories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-index">
    <br>
    <br>
    <div class="row">
        <div class="col-lg-3 eArLangCss">
            <div class="box box-info collapsed-box">
                <div class="box-header with-border">
                  <p>
                    <?= Html::button('<i class="fa fa-plus"></i>', ['value' => Url::to(['inventory/create']), 'title' => Yii::t('inventory', 'Add New Inventory'), 'class' => 'btn btn-flat bg-blue showModalButton']); ?>
                    <?= Html::button('<i class="fa fa-plus"></i>', ['value' => Url::to(['category/create']), 'title' => Yii::t('inventory', 'Add New Category'), 'class' => 'btn btn-flat bg-green showModalButton']); ?>
                    <?= Html::button('<i class="fa fa-plus"></i>', ['value' => Url::to(['product/create']), 'title' => Yii::t('inventory', 'Add New Item'), 'class' => 'btn btn-flat bg-orange showModalButton']); ?>
                    <?= Html::button('<i class="fa fa-plus"></i>', ['value' => Url::to(['stocking/create']), 'title' => Yii::t('inventory', 'Add New Stock'), 'class' => 'btn btn-flat bg-maroon showModalButton']); ?>

                  </p>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-2x fa-plus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="display: none;">
                    <?php 
                        $trans = new Inventory();
                        echo $this->render('transfere', ['trans' => $trans]); 
                    ?>
                </div>
                <!-- /.box-body -->
            </div>
            <?php foreach ($inventories as $k => $inventory ) {  $color = $inventory->color_class ;?>
                  <!-- Widget: user widget style 1 -->
                  <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header <?=$color?>">
                      
                      <h3 class="widget-user-username"><?=Html::a($inventory->name, ['inventory/view', 'id'=>$inventory->id], ['class' => 'text-white'])?></h3>
                      <h5 class="widget-user-desc"><?=$inventory->address?></h5>
                    </div>
                    <div class="pull-left">
                        <?= Html::button('<i class="fa fa-edit"></i>', ['value' => Url::to(['inventory/update', 'id'=>$inventory->id]), 'title' => Yii::t('inventory', 'update'), 'class' => ' btn btn-sm btn-flat <?= $color ?> showModalButton']); ?>
                    </div>
                    <div class="box-footer">
                      <div class="row">
                        <div class="col-sm-4 border-right eArLangCss">
                          <div class="description-block">
                            <h5 class="description-header">
                                <span class="badge bg-red"><?= Yii::$app->formatter->asDecimal(round($inventory->expense->balance * Yii::$app->mycomponent->rate())) ?></span>
                            </h5>
                            <span class="description-text"><?=Yii::t('inventory', 'Cost of Goods')?></span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right eArLangCss">
                          <div class="description-block">
                            <h5 class="description-header">
                                <span class="badge bg-green"><?= Yii::$app->formatter->asDecimal(round($inventory->asset->balance* Yii::$app->mycomponent->rate())) ?></span>
                            </h5>
                            <span class="description-text"><?=Yii::t('inventory', 'Stock Value')?></span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right eArLangCss">
                          <div class="description-block">
                            <h5 class="description-header">
                                <span class="badge bg-aqua"> <?= Yii::$app->formatter->asDecimal($inventory->stocksCount)  ?></span>
                            </h5>
                            <span class="description-text"><?=Yii::t('inventory', 'Items Count')?></span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                    </div>
                  </div>
                  <!-- /.widget-user -->

            <?php 
            }?>
        </div>
        <div class="col-lg-9 eArLangCss">
            <div class="box box-info">
            <?php 
                $gridColumns  = 
                    [   
                           
                        [
                            'class'=>'kartik\grid\DataColumn',
                            'attribute'=> 'inventory_id',
                            'header'=> Yii::t('inventory', 'Inventory') ,
                            'headerOptions'=>['class'=>'kartik-sheet-style'],
                            'hAlign'=>'center',
                            'vAlign'=>'center',
                            'width'=>'18%',
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
                                            0=>Yii::t('inventory', 'total inventory items : '),
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
                            'header'=> Yii::t('inventory', 'Category') ,
                            'width'=>'15%',
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
                                        1=>Yii::t('inventory', 'total category items : '),
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
                            'header'=> Yii::t('inventory', 'Product'),
                            'width'=>'15%',
                            'headerOptions'=>['class'=>'kartik-sheet-style'],
                            'hAlign'=>'center',
                            'vAlign'=>'center',
                            'footer'=>true 
                        ],
                        [   
                            'attribute'=>'quantity',
                            'header'=> Yii::t('inventory', 'Quantity'),
                            'width'=>'8%',
                            'format'=>['decimal'],
                            'headerOptions'=>['class'=>'kartik-sheet-style'],
                            'hAlign'=>'center',
                            'vAlign'=>'center',
                            'pageSummary'=>true,
                            'footer'=>true
                        ],
                        [
                            'class'=>'kartik\grid\DataColumn',
                            'header'=> Yii::t('inventory', 'Buying Price') ,
                            'width'=>'11%',
                            'headerOptions'=>['class'=>'kartik-sheet-style'],
                            'hAlign'=>'center',
                            'vAlign'=>'center',   
                            'width'=>'8%',
                            'format'=>['decimal'],
                            'value' =>function ($model, $key, $index, $widget) { 
                                $current_rate = Yii::$app->mycomponent->rate();
                                if ($current_rate > $model->highest_rate) {
                                    $rate = $current_rate;
                                }else{
                                   $rate = $model->highest_rate; 
                                }
                                return round($model->product->buying_price*$rate);                    
                            },
                        ],
                        [
                            'class'=>'kartik\grid\DataColumn',
                            'header'=> Yii::t('inventory', 'Selling Price'),
                            'width'=>'11%',
                            'headerOptions'=>['class'=>'kartik-sheet-style'],
                            'hAlign'=>'center',
                            'vAlign'=>'center',
                            'format'=>['decimal'],
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
                            'attribute'=> Yii::t('inventory', 'Margin Profit'),
                            'headerOptions'=>['class'=>'kartik-sheet-style'],
                            'hAlign'=>'center',
                            'vAlign'=>'center',
                            'width'=>'8%',
                            
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
                            'header'=> Yii::t('inventory', 'Active Rate'),
                            'format'=>['decimal'],
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
                            'header'=> Yii::t('inventory', 'Total'),
                            'headerOptions'=>['class'=>'kartik-sheet-style'],
                            'format'=>['decimal'],
                            'width'=>'8%',
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
                        /*[
                            'class' => 'kartik\grid\ActionColumn',
                            'header' => "",
                            'width' => '5%',
                            'template' => '{view} ',
                            // 'viewOptions'=>['lable'=>'<i class="glyphicon glyphicon-remove"></i>'],
                            // 'updateOptions'=>['null' => true],
                            // 'deleteOptions'=>['null' => true],
                        ],*/
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
                    'exportConfig' => [ 
                        GridView::PDF => [
                            'label' => Yii::t('app', 'Type PDF'),
                            'icon' => 'floppy-disk',
                            'iconOptions' => ['class' => 'text-danger'],
                            'showHeader' => true,
                            'showPageSummary' => true,
                            'showFooter' => true,
                            'showCaption' => true,
                            'filename' => Yii::t('app', 'Inventories'),
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
                              'cssInline' => 'body { direction: rtl; font-family: Alarabiya;} th { text-align: right; } td { text-align: right;}',
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
                            'id'=>'Inventories',
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
                    'panel' => [
                        'type' => GridView::TYPE_INFO,
                        'heading' => '<i class="fa  fa-hospital-o"></i><strong></strong>',

                    ],
                    
                ]); 
            ?>
            </div>
        </div>
    </div>
         
        
        <div class="col-sm-12">
        
        </div>
        
   
    
</div>
 