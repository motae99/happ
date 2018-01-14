<?php 
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;

// Yii::$app->formatter->asDecimal($model->returned($model))
?>
<div class="col-sm-10">
	 <?php 
        $dataProvider =  new ActiveDataProvider([
            'query' => \app\models\Stocking::find(),
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC, ]],
            'pagination' => false,
        ]);
        $dataProvider->query->where(['inventory_id'=>$model->inventory_id, 'product_id'=>$model->product_id])->all();
        // $dataProvider->pagination = ['defaultPageSize' => 10];

       $gridColumns  = 
        [   
            [	
                'class'=>'kartik\grid\DataColumn',
                'attribute'=> 'rate',
                'header'=> Yii::t('inventory', 'USD'),
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center', 
                'format'=>['decimal'],
                'width'=>'8%',

            ],
           /* [
                'class'=>'kartik\grid\DataColumn',
                'attribute'=> 'quantity',
                'header'=> Yii::t('inventory', 'quantity'),
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                'pageSummary'=>true,
                'footer'=>true
            ],*/
            [
                'class'=>'kartik\grid\DataColumn',
                'attribute'=>'selling_price',
                'header'=> Yii::t('inventory', 'Sold OUT'),
                'headerOptions'=>['class'=>'bg-green'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                'width'=>'10%',
                'format' => 'decimal',
                

                'value' =>function ($model, $key, $index, $widget) { 
                    if ($model->transaction == 'out') {
                        return $model->quantity; 
                    }else{
                        return "";
                    }
                },
                'contentOptions' => function ($model, $key, $index, $column) {
                    // $active = $model->product->active;
                    // if ($active == "percentage") {
                    //     return ['style' => 'color:green; font-weight: bold;' ];
                    // }
                    
                },

                'pageSummary'=>true,
                'footer'=>true
            ],
            [
                'class'=>'kartik\grid\DataColumn',
                'header'=> Yii::t('inventory', 'Transfered'),
                'headerOptions'=>['class'=>'bg-orange'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                'width'=>'10%',
                'format' => 'decimal',
                'value' =>function ($model, $key, $index, $widget) { 
                    if ($model->transaction == "transfered") {
                        return $model->quantity;
                        // return round($model->buying_price*$model->rate, 2);                    
                    }else{
                        return "0";
                    }
                },
                // 'contentOptions' => function ($model, $key, $index, $column) {
                //     $active = $model->product->active;
                //     if ($active == "percentage") {
                //         return ['style' => 'color:green; font-weight: bold;' ];
                //     }
                    
                // },

                'pageSummary'=>true,
                'footer'=>true
            ],
            [
                'class'=>'kartik\grid\DataColumn',
                'header'=> Yii::t('inventory', 'Returned'),
                'headerOptions'=>['class'=>'bg-red'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                'width'=>'10%',
                'format' => 'decimal',
                'value' =>function ($model, $key, $index, $widget) { 
                    if ($model->transaction == "returned") {
                        return $model->quantity;                   
                        // return round($model->buying_price*$model->rate, 2);                    
                    }else{
                        return "0";
                    }                   
                },
                // 'contentOptions' => function ($model, $key, $index, $column) {
                //     $active = $model->product->active;
                //     if ($active == "percentage") {
                //         return ['style' => 'color:green; font-weight: bold;' ];
                //     }
                    
                // },

                'pageSummary'=>true,
                'footer'=>true
            ],
            [
                'attribute'=>'buying_price',
                'header'=> Yii::t('inventory', 'Stocked IN'),
                //  'width'=>'16%',
                'headerOptions'=>['class'=>'bg-blue'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                'width'=>'10%',
                'format' => 'decimal',
                'value' =>function ($model, $key, $index, $widget) { 
                    if ($model->transaction == "in") {
                        return $model->quantity;                   
	                    
                        // return round($model->buying_price*$model->quantity*$model->rate, 2);                    
                    }else{
                    	return "0";
                    }  
                    
                                      
                },
                'contentOptions' => function ($model, $key, $index, $column) {
                    // $active = $model->product->active;
                    // if ($active == "percentage") {
                    //     return ['style' => 'color:green; font-weight: bold;' ];
                    // }
                    
                },

                'pageSummary'=>true,
                'footer'=>true
            ],
            [
                'class'=>'kartik\grid\DataColumn',
                'header'=> Yii::t('inventory', 'Reference'),
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',   
                // 'width'=>'15%',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                    if ($model->transaction == 'out' || $model->transaction == 'returned') {
                    	return  Html::a('<i class="fa fa-search"> </i>' , ['invoices/view', 'id' => $model->invoproduct->invoice_id]);
                    }elseif ($model->transaction == 'transfered') {
                         // $ref = \app\models\Stocking::find()->where(['id' => $model->reference])->one();
                        return  'No Reference'; //Html::a('<i class="fa fa-search"> </i>' , ['inventory/view', 'id' => $ref->inventory_id]);
                    }else{
                    	return Yii::t('inventory', 'No Reference');
                    }
                }
            ],
            [
                'class'=>'kartik\grid\DataColumn',
                'attribute'=> 'created_at',
                'header'=> Yii::t('inventory', 'Created AT'),
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',   
                'format' => 'date',
                // // 'width'=>'15%',
                // 'value' =>function ($model, $key, $index, $widget) { 
                //     $current_rate = Yii::$app->mycomponent->rate();
                //     if ($current_rate > $model->highest_rate) {
                //         $rate = $current_rate;
                //     }else{
                //        $rate = $model->highest_rate; 
                //     }
                //     return round($model->avg_cost*$rate, 2);                    
                // },
            ],
        ]

    ?>
    <?php echo  GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            if ($model->transaction == 'in') {
                return ['class' => 'info'];
            }
            elseif ($model->transaction == 'out') {
            	return ['class' => 'success'];
            }
            elseif ($model->transaction == 'transfered') {
            	return ['class' => 'warning'];
            }
            elseif ($model->transaction == 'returned') {
            	return ['class' => 'danger'];
            }
        },
        'columns' => $gridColumns,
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'responsiveWrap' => true,
        'hover' => true,
        'floatHeader' => false,
       // 'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
        'showPageSummary' => true,
        // 'panel' => [
        //     'type' => GridView::TYPE_INFO,
        //     'heading' => '<i class="fa  fa-hospital-o"></i><strong>       Stock</strong>',

        // ],
        
    ]); ?>
</div>
<div class="col-sm-2">
	<br>
    <div class="small-box bg-green">
        <div class="inner">
        <?php $sold = \app\models\Stocking::find()->where(['inventory_id'=>$model->inventory_id, 'product_id'=>$model->product_id, 'transaction'=> 'out'])->sum('quantity'); ?>
          <h3><?=$sold?><sup style="font-size: 20px">
          </sup></h3>

          <p><?=Yii::t('inventory', 'Total Sold Value')?></p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
    <div class="small-box bg-orange">
        <div class="inner">
        <?php $t = \app\models\Stocking::find()->where(['inventory_id'=>$model->inventory_id, 'product_id'=>$model->product_id, 'transaction'=> 'transfered'])->sum('quantity'); ?>

          <h3><?=$t?><sup style="font-size: 20px">
          </sup></h3>

          <p><?=Yii::t('inventory', 'Total Transfered Value')?></p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
    <div class="small-box bg-red">
        <div class="inner">
        <?php $r = \app\models\Stocking::find()->where(['inventory_id'=>$model->inventory_id, 'product_id'=>$model->product_id, 'transaction'=> 'returned'])->sum('quantity'); ?>

          <h3><?=$r?><sup style="font-size: 20px">
          </sup></h3>

          <p><?=Yii::t('inventory', 'Total Returned Value')?></p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
	<div class="small-box bg-blue">
	    <div class="inner">
            <?php $in = \app\models\Stocking::find()->where(['inventory_id'=>$model->inventory_id, 'product_id'=>$model->product_id, 'transaction'=> 'in'])->sum('quantity'); ?>
	      <h3><?=$in?><sup style="font-size: 20px">
          </sup></h3>

	      <p><?=Yii::t('inventory', 'Total Stock Value')?></p>
	    </div>
	    <div class="icon">
	      <i class="ion ion-stats-bars"></i>
	    </div>
	    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
  	</div>
  	
</div>