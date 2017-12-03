<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\InvoicesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Invoices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoices-index">
    <br>
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Bookmarks</span>
              <span class="info-box-number">41,410</span>

              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
                  <span class="progress-description">
                    70% Increase in 30 Days
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Likes</span>
              <span class="info-box-number">41,410</span>

              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
                  <span class="progress-description">
                    70% Increase in 30 Days
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-calendar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Events</span>
              <span class="info-box-number">41,410</span>

              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
                  <span class="progress-description">
                    70% Increase in 30 Days
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Comments</span>
              <span class="info-box-number">41,410</span>

              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
                  <span class="progress-description">
                    70% Increase in 30 Days
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    
    <?php 
        $gridColumns  = 
        [   
            [ 
                'class'=>'kartik\grid\ExpandRowColumn',
                'width'=>'5%',
                'value'=>function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail'=>function ($model, $key, $index, $column) {
                    return Yii::$app->controller->renderPartial('_inner', ['model'=>$model]);
                },
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'expandOneOnly'=>true
            ],
            [
                // 'attribute'=>'inventory_id',
                'header'=> Yii::t('invo', 'checkMe'),
                // 'width'=>'26%',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'value' =>function ($model, $key, $index, $widget) { 
                    return $model->inventory->name;                    
                    },
                'group'=>true,
                // 'groupFooter'=>function ($model, $key, $index, $widget) { 
                //     return [
                //        'mergeColumns'=>[[0,3], [7,8]],
                //         'content'=>[             
                //             1=>Yii::t('invo', 'inventory total :'),
                //             // 2=>GridView::F_COUNT,
                //             4=>GridView::F_SUM,
                //             5=>GridView::F_SUM,
                //             6=>GridView::F_SUM,
                //          ],
                //         'contentFormats'=>[
                //             1=>['style'=>'font-variant:small-caps'],      
                //             4=>['format'=>'number', 'decimals'=>2, 'thousandSep' => ' '],
                //             5=>['format'=>'number', 'decimals'=>2, 'thousandSep' => ' '],
                //             6=>['format'=>'number', 'decimals'=>2, 'thousandSep' => ' '],

                //         ],
                //         'contentOptions'=>[      

                //             4=>['style'=>'color:red;'],
                //             5=>['style'=>'color:blue;'],
                //             6=>['style'=>'color:green;'],
                //     ],

                //         'options'=>['class'=>'success','style'=>'font-weight:bold;']
                //     ];
                // },
            ],
            [
                'class'=>'kartik\grid\DataColumn',
                'attribute'=>'client_id',
                // 'header'=> Yii::t('invo', 'checkMe')'Client',
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
                // 'header'=> Yii::t('invo', 'checkMe')'#NO',
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
                'headerOptions'=>['class'=>'bg-red'],
                'hAlign'=>'center',
                'footer'=>true ,
                'pageSummary'=>true,
                'width'=>'10%',
                'format' => 'raw',
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
                'headerOptions'=>['class'=>'bg-blue'],
                'hAlign'=>'center',
                'width'=>'10%',
                'format' => 'raw',
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
                'headerOptions'=>['class'=>'bg-green'],
                // 'format'=>['decimal', 2],
                'mergeHeader'=>true, 
                'width'=>'10%',
                'hAlign'=>'center', 
                'value'=>function ($model, $key, $index, $widget) { 
                    $p = compact('model', 'key', 'index');
                    return $widget->col(5, $p) - $widget->col(4, $p) ;
                },
                
                'pageSummary'=>true,
                'footer'=>true 
            ],
            [
                'class'=>'kartik\grid\DataColumn',
                'attribute'=>'status',
                // 'header'=> Yii::t('invo', 'S'),
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'width'=>'5%',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                    if ($model->status == "paid") {
                        return '<i class="fa fa-2x fa-check-circle" style="color: green;"></i>';
                    }elseif($model->status == "partially"){
                        return '<i class="fa fa-2x fa-minus-circle" style="color: orange;"></i>';
                    }else{
                        return '<i class="fa fa-2x fa-times-circle" style="color: red;"></i>';
                    }
                                      
                },
            ],
            [
                'attribute'=>'date',
                // 'header'=> Yii::t('invo', 'Date'),
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'format' => 'raw',
                'width'=>'8%',
                /*'value' =>function ($model, $key, $index, $widget) { 
                    $current_rate = Yii::$app->mycomponent->rate();
                    if ($current_rate > $model->highest_rate) {
                        $rate = $current_rate;
                    }else{
                       $rate = $model->highest_rate; 
                    }
                    return $rate;                    
                },*/
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'header' => "",
                'width' => '5%',
                'template' => '{view} ',
                // 'viewOptions'=>['lable'=>'<i class="glyphicon glyphicon-remove"></i>'],
                // 'updateOptions'=>['null' => true],
                // 'deleteOptions'=>['null' => true],
            ],
        ]
    ?>

    <?php echo  GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => $gridColumns,

        /*'rowOptions' => function ($model) {
            if ($model->status !== "paid") {
                return ['class' => 'danger'];
            }
        },*/
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
        // 'floatHeader' => true,
       // 'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
        'showPageSummary' => true,
        // 'panel' => [
        //     'type' => GridView::TYPE_INFO,
        //     'heading' => '<i class="fa  fa-hospital-o"></i><strong>       Stock</strong>',

        // ],
        
    ]); ?>
</div>
