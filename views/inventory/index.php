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

$this->title = Yii::t('app', 'Inventories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-index">

    <h1></h1>
         
          <div class="box box-info collapsed-box">
            <div class="box-header with-border">
              <p class="box-title">
                <?= Html::button('<i class="fa fa-plus"></i>', ['value' => Url::to(['inventory/create']), 'title' => Yii::t('inventory', 'Add New Inventory'), 'class' => 'btn btn-flat bg-blue showModalButton']); ?>
                <?= Html::button('<i class="fa fa-plus"></i>', ['value' => Url::to(['category/create']), 'title' => Yii::t('inventory', 'Add New Category'), 'class' => 'btn btn-flat bg-green showModalButton']); ?>
                <?= Html::button('<i class="fa fa-plus"></i>', ['value' => Url::to(['product/create']), 'title' => Yii::t('inventory', 'Add New Item'), 'class' => 'btn btn-flat bg-orange showModalButton']); ?>

              </p>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-2x fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="display: none;">
                <div class="col-sm-6 eArLangCss">
                    <?= Html::button('<i class="fa fa-plus"> Stock</i>', ['value' => Url::to(['stocking/create']), 'title' => 'Add', 'class' => 'btn btn-flat bg-blue showModalButton']); ?>
                </div>
                <div class="col-sm-6 eArLangCss">
                    
                    <?php 
                        $trans = new Inventory();
                        echo $this->render('transfere', ['trans' => $trans]); 
                    ?>
                </div>
            </div>
            <!-- /.box-body -->
          </div>
        <div class="col-sm-12">
        <?php foreach ($inventories as $k => $inventory ) {  $color = $inventory->color_class ;?>

            <div class="col-md-4 eArLangCss">
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
                    <div class="col-sm-3 border-right eArLangCss">
                      <div class="description-block">
                        <h5 class="description-header">
                            <span class="badge bg-red"><?= round($inventory->expense->balance* Yii::$app->mycomponent->rate(), 2)?></span>
                        </h5>
                        <span class="description-text"><?=Yii::t('inventory', 'Cost of Goods')?></span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 border-right eArLangCss">
                      <div class="description-block">
                        <h5 class="description-header">
                            <span class="badge bg-green"><?= round($inventory->asset->balance* Yii::$app->mycomponent->rate(), 2)?></span>
                        </h5>
                        <span class="description-text"><?=Yii::t('inventory', 'Stock Value')?></span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 border-right eArLangCss">
                      <div class="description-block">
                        <h5 class="description-header">
                            <span class="badge bg-aqua"> <?= $inventory->stocksCount ?></span>
                        </h5>
                        <span class="description-text"><?=Yii::t('inventory', 'Items')?></span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 border-right eArLangCss">
                      <div class="description-block">
                        <h5 class="description-header">
                            <span class="badge bg-purple"><?= $inventory->invoicesCount ?></span>
                        </h5>
                        <span class="description-text"><?=Yii::t('inventory', 'Invoices')?></span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
              </div>
              <!-- /.widget-user -->
            </div>

        <?php 
        }?>
        </div>
        
   
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
                'width'=>'16%',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                'footer'=>true 
            ],
            [   
                'attribute'=>'quantity',
                'header'=> Yii::t('inventory', 'Quantity'),
                'width'=>'11%',
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
                'header'=> Yii::t('inventory', 'Selling Price'),
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
                'header'=> Yii::t('inventory', 'Active Rate'),
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
                'header'=> Yii::t('inventory', 'Total'),
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                // 'format'=>['decimal', 2],
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
        //     'heading' => '<i class="fa  fa-hospital-o"></i><strong></strong>',

        // ],
        
    ]); ?>
</div>
 