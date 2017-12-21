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
            'query' => \app\models\SystemAccount::find(),
            // 'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC, ]],
            // 'pagination' => true,

        ]);
    // $dataProvider->query->where(['account_id' => $model->account_id])->all();
    // $dataProvider->query->where(['client_id' => $model->id])->all();account_id

    

?>

<?= GridView::widget([
            'dataProvider' => $dataProvider,
            'showPageSummary'=>true,
            // 'pjax'=>true,
            'striped'=>true,
            'hover'=>true,
            'toolbar' =>  [
             ['content'=>
                Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'Do Something', 'class'=>'btn btn-info', 'onclick'=>'alert("This will launch nothing.\n\nBut set to do something later!");']) . ' ' .
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'Reset'])
                ],
                '{export}',
                '{toggleData}'
            ],
            'panel'=>['type'=>'primary', 'heading'=>'Double Entry'],
            'columns' => [
               // ['class'=>'kartik\grid\SerialColumn'],
                // [
                //     'class'=>'kartik\grid\DataColumn',
                //     'attribute'=>'date', 
                //     // 'format'=>'date',
                //     'width'=>'2px',
                //         'group'=>true,  // enable grouping
                //         'groupedRow'=>true,                    // move grouped column to a single grouped row
                //         'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                //         'groupEvenCssClass'=>'kv-grouped-row',
                //         'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
                //             return [
                //                 'mergeColumns'=>[[1,3]], // columns to merge in summary
                //                 'content'=>[             // content to show in each summary cell
                //                     1=>Yii::t('app','On Date : ').'(' . $model->date . ')',
                //                     4=>GridView::F_SUM,
                //                     5=>GridView::F_SUM,
                //                    // 6=>(4=>GridView::F_SUM)-(5=>GridView::F_SUM) ,
                //                 ],
                //                 'contentFormats'=>[      // content reformatting for each summary cell
                //                     4=>['format'=>'number', 'decimals'=>2],
                //                     5=>['format'=>'number', 'decimals'=>2],
                //                    // 6=>['format'=>'number', 'decimals'=>2],
                //                 ],
                //                 'contentOptions'=>[      // content html attributes for each summary cell
                //                     1=>['style'=>'font-variant:small-caps'],
                //                     4=>['style'=>'text-align:center'],
                //                     5=>['style'=>'text-align:center'],
                //                    // 6=>['style'=>'text-align:right'],
                //                 ],
                //                 // html attributes for group summary row
                //                 'options'=>['class'=>'bg-olive','style'=>'font-weight:bold;']
                //             ];
                //         }
                    
                // ],
                [
                'class'=>'kartik\grid\DataColumn',
                'attribute'=> 'transaction_id',
                'format' => 'raw',
                'width'=>'5px',
                // 'value' =>function ($model, $key, $index, $widget) {
                //     $reference = $model->transaction->reference;
                //     $reference_type = $model->transaction->reference_type; 
                //         if($reference_type == 'Invoices' ){
                //              return Html::a('<i class="glyphicon glyphicon-zoom-in"></i> ', ['invoices/view', 'id' => $reference]); 
                //         }
                //         // else{
                //         //     return $reference;
                //         //     // return   Html::button($model->transaction_id, ['value' => "index.php?".ucfirst($reference_type)."Search[id]=$reference&r=$reference_type/reference", 'title' => 'Refere', 'class' => 'showModalButton btn-flat bg-maroon glyphicon glyphicon-zoom-in']);              
                //         // }
                //     },
                'group'=>true,
                'subGroupOf'=>0, 
                'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
                    return [
                            'mergeColumns'=>[[1,3]], // columns to merge in summary
                            'content'=>[             // content to show in each summary cell
                                2=>Yii::t('app','Transaction # '). $model->transaction_id . ' ',
                                4=>GridView::F_SUM,
                                5=>GridView::F_SUM,
                            ],
                            'contentFormats'=>[      // content reformatting for each summary cell
                                4=>['format'=>'number', 'decimals'=>2],
                                5=>['format'=>'number', 'decimals'=>2],
                            ],
                            'contentOptions'=>[      // content html attributes for each summary cell
                                2=>['style'=>'font-variant:small-caps'],
                                4=>['style'=>'text-align:center'],
                                5=>['style'=>'text-align:center'],
                            ],
                            // html attributes for group summary row
                            'options'=>['class'=>'bg-purple','style'=>'font-weight:bold;']
                        ];
                    },
                ],
               
                [
                'class'=>'kartik\grid\DataColumn',
                'attribute'=>'account_id',
                'width'=>'250px',
                'value' =>function ($model, $key, $index, $widget) { 
                        //$account = SystemAccount::find()->where(['id' => $model->account_id])->one();
                        return $model->systemAccount->system_account_name;
                    },
                
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                //'mergeHeader'=>true,
                ],
               [
                'class'=>'kartik\grid\DataColumn',
                'attribute'=>'description',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'mergeHeader'=>true,
                ],
                [
                'class'=>'kartik\grid\DataColumn',
                'header'=>'dr',
                'format'=>'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                //         $increase = $model->systemAccount->to_increase ;
                //         if($increase == 'debit' && $model->systemAccount->account_type_id == 1 && $model->systemAccount->group != 'client'){
                //             $class = 'glyphicon glyphicon-chevron-up ';
                //             $style = 'color: green;';
                //         }elseif($increase == 'debit' && $model->systemAccount->account_type_id == 2 || $model->systemAccount->account_type_id == 4 || $model->systemAccount->account_type_id == 5 || $model->systemAccount->group == 'client' ){
                //             $class = 'glyphicon glyphicon-chevron-up ';
                //             $style = 'color: red;';
                //         }else{
                //             $class = 'glyphicon glyphicon-chevron-down ';
                //             $style = 'color: red;';

                //         }
                //         if($model->is_depit == 'yes'){
                //           return  Html::tag('span', $model->amount , ['class'=>$class, 'style'=>$style ]);
                         
                //         }else{
                            return 0;
                        // }
                    },

                'pageSummary'=>true,
                'footer'=>true,
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'mergeHeader'=>true,
                ],
                [
                'header'=>'cr',
                'format'=>'raw',
                'value' =>function ($model, $key, $index, $widget) { 
                       // $increase = $model->systemAccount->to_increase ;
                       //  if($increase == 'credit' && $model->systemAccount->account_type_id == 4 ){
                       //      $class = 'glyphicon glyphicon-chevron-up ';
                       //      $style = 'color: green;';
                       //  }elseif($increase == 'credit' && $model->systemAccount->account_type_id == 2 ){
                       //      $class = 'glyphicon glyphicon-chevron-up ';
                       //      $style = 'color: red;';
                       //  }elseif($model->systemAccount->group == 'client' || $model->systemAccount->account_type_id == 5){
                       //      $class = 'glyphicon glyphicon-chevron-down ';
                       //      $style = 'color: green;';
                       //  }else{
                       //      $class = 'glyphicon glyphicon-chevron-down ';
                       //      $style = 'color: red;';
                       //  }
                       //  if($model->is_depit == 'no'){
                       //    return  Html::tag('span', $model->amount , ['class'=>$class, 'style'=>$style ]);
                         
                       //  }else{
                            return 0;
                        // }
                    },
                'pageSummary'=>true,
                'footer'=>true,
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'mergeHeader'=>true,
                           

                ],
                 [
               // 'class'=>'kartik\grid\DataColumn',
                'attribute'=>'balance',        
                // 'format'=>['decimal', 2],
                'value' =>function ($model, $key, $index, $widget) { 
                        if($model->balance > 0){
                          return  $model->balance;  
                        }else{
                            return $model->balance; 
                        }
                    // key point is to use relational getaccount without get           
                    },
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'hAlign'=>'center',
                'mergeHeader'=>true,
                ],

            ],
        ]); ?>