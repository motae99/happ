<?php 
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;

?>
<div class="col-sm-8">
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
                'header'=> Yii::t('inventory', 'USD Rate'),
                // 'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',   
                // // 'width'=>'15%',
                // 'format' => 'raw',
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
            [
                'class'=>'kartik\grid\DataColumn',
                'attribute'=> 'quantity',
                'header'=> Yii::t('inventory', 'quantity'),
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                // 'width'=>'15%',
                // 'format' => 'raw',
                // 'value' =>function ($model, $key, $index, $widget) { 
                //     return $model->trans($model);                    
                // },
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
                'width'=>'16%',
                'headerOptions'=>['class'=>'bg-blue'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                'width'=>'15%',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                    if ($model->transaction == "in") {
	                    return round($model->buying_price*$model->quantity*$model->rate, 2);                    
                    }else{
                    	return "----";
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
                'attribute'=>'selling_price',
                'header'=> Yii::t('inventory', 'Sold OUT'),
                'headerOptions'=>['class'=>'bg-green'],
                'hAlign'=>'center',
                'vAlign'=>'center',
                'width'=>'15%',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                    if ($model->transaction == 'out') {
                    	return round($model->quantity*$model->selling_price*$model->rate, 2); 
                    }else{
                    	return "----";
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
                'width'=>'15%',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                    if ($model->transaction == "transfered") {
	                    return round($model->buying_price*$model->rate, 2);                    
                    }else{
                    	return "----";
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
                // 'width'=>'15%',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                    if ($model->transaction == "returned") {
	                    return round($model->buying_price*$model->rate, 2);                    
                    }else{
                    	return "----";
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
                'header'=> Yii::t('inventory', 'Reference'),
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',   
                // 'width'=>'15%',
                'format' => 'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                    $i_p = \app\models\InvoiceProduct::find()->where(['stocking_id' => $model->id])->exists();
                    if ($i_p && $model->transaction == 'out') {
                    	$refere = \app\models\InvoiceProduct::find()->where(['stocking_id' => $model->id])->one();
                    	return $refere->invoice_id; 
                    }else{
                    	return Yii::t('inventory', 'No Reference');
                    }
                }
            ],
            [
                'class'=>'kartik\grid\DataColumn',
                'attribute'=> 'created_at',
                'header'=> Yii::t('inventory', 'Created AT'),
                'header'=> 'Time',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'vAlign'=>'center',   
                // // 'width'=>'15%',
                // 'format' => 'raw',
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
<div class="col-sm-4">
	<br>
	<div class="small-box bg-blue">
	    <div class="inner">
	      <h3>53<sup style="font-size: 20px">%</sup></h3>

	      <p>Stocked IN</p>
	    </div>
	    <div class="icon">
	      <i class="ion ion-stats-bars"></i>
	    </div>
	    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
  	</div>
  	<div class="small-box bg-green">
	    <div class="inner">
	      <h3>53<sup style="font-size: 20px">%</sup></h3>

	      <p>Sold OUT</p>
	    </div>
	    <div class="icon">
	      <i class="ion ion-stats-bars"></i>
	    </div>
	    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
  	</div>
  	<div class="small-box bg-orange">
	    <div class="inner">
	      <h3>53<sup style="font-size: 20px">%</sup></h3>

	      <p>Transfered</p>
	    </div>
	    <div class="icon">
	      <i class="ion ion-stats-bars"></i>
	    </div>
	    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
  	</div>
  	<div class="small-box bg-red">
	    <div class="inner">
	      <h3>53<sup style="font-size: 20px">%</sup></h3>

	      <p>returned</p>
	    </div>
	    <div class="icon">
	      <i class="ion ion-stats-bars"></i>
	    </div>
	    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
  	</div>
</div>