<?php 
use yii\helpers\Html;
use app\models\SystemAccount;
use dosamigos\chartjs\ChartJs;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\Invoices;
use app\models\InvoiceProduct;



?> 


<div class="row">
  <div class="col-md-12 eArLangCss">
    <div class="box box-info collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('app', 'New Invoices')?></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <?php 
          $model = new Invoices();
          $modelsItem = [new InvoiceProduct];
          echo $this->render('sell', [
                    'model' => $model,
                    'modelsItem' => (empty($modelsItem)) ? [new InvoiceProduct] : $modelsItem
                ]);

        ?>
      </div>
    </div>
  </div>
</div>

<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <div class="col-md-4 eArLangCss">
    <!-- Info Boxes Style 2 -->
      <?php $dues = \app\models\Outstanding::find()->where(['cheque_date' => date('Y-m-d'), 'status'=>'outstanding'])->all(); 
        if ($dues) {
          foreach ($dues as $due) { 
      ?>

    <div class="info-box <?= $due->client->color_class?>">
      <span class="info-box-icon" >
        <?php 
          $cash = SystemAccount::find()->where(['account_no' => '1100'])->one();
          if ($due->cheque_date) {
              $class = " fa fa-bank ";
          }else{
            $class = " fa fa-money ";
          }
          echo Html::a(Yii::t('app', ''), ['invoices/reconcile', 'account_id' => $due->client->account_id, 'invoice_id' =>$due->invoice_id, 'outstanding_id' => $due->id], ['class' => $class]);
        ?>
      </span>

      <div class="info-box-content">
        <span class="info-box-text"><?=$due->client->client_name?></span>
        <span class="info-box-number"><?=$due->amount?></span>

        <div class="progress">
          <div class="progress-bar" style="width: 50%"></div>
        </div>
        <span class="progress-description">
              <?php 
                if ($due->cheque_date) {
                    echo $due->bank." # ".$due->cheque_no;
                }
              ?>
            </span>
      </div>

      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
      <?php 
              }
            }
      ?>
    
    
    <!-- DO IT LATER -->

    <!-- <div class="box box-solid">
      <div class="box-header with-border">
        <h4 class="box-title">Schedueled Pyaments</h4>
      </div>
      <div class="box-body">
        <!-- the events -->
       <!--  <div id="external-events"><div style="background-color: rgb(243, 156, 18); border-color: rgb(243, 156, 18); color: rgb(255, 255, 255); position: relative;" class="external-event ui-draggable ui-draggable-handle">any</div>
          <div class="external-event bg-green ui-draggable ui-draggable-handle" style="position: relative; z-index: auto; width: 231.5px; right: auto; height: 30px; bottom: auto; left: 0px; top: 0px;">Lunch</div>
          <div class="external-event bg-yellow ui-draggable ui-draggable-handle" style="position: relative;">Go home</div>
          <div class="external-event bg-aqua ui-draggable ui-draggable-handle" style="position: relative;">Do homework</div>
          <div class="external-event bg-light-blue ui-draggable ui-draggable-handle" style="position: relative; z-index: auto; width: 276.5px; right: auto; height: 30px; bottom: auto; left: 0px; top: 0px;">Work on UI design</div>
          
          <div class="checkbox">
            <label for="drop-remove">
              <input id="drop-remove" type="checkbox">
              remove after drop
            </label>
          </div>
        </div>
      </div> -->
      <!-- /.box-body -->
    <!-- </div>  -->

    
        <?php $minimals = \app\models\Minimal::find()->all(); 
          if ($minimals) { ?>
          <table class="table table-bordered table-responsive bg-white">
            <tr class="bg-orange">
              <th width="35%"><?= Yii::t('app', 'Inventory')?></th>
              <th width="35%"><?= Yii::t('app', 'Item')?></th>
              <th width="15%"><?= Yii::t('app', 'Q')?></th>
              <th width="15%"><?= Yii::t('app', 'M')?></th>
            </tr>
        <?php foreach ($minimals as $m) { ?>
            <tr>
              <td width="35%"><?= Html::a($m->stock->inventory->name , ['inventory/view', 'id' => $m->stock->inventory->id])?></td>
              <td width="35%"><?=$m->stock->product_name?></td>
              <td width="15%"> <i class="badge bg-red"><?=$m->stock->quantity?></i> </td>
              <td width="15%"> <i style="color: orange;" class="fa fa-angle-double-down"> </i>  <?=$m->quantity?></td>
            </tr>  
        <?php } ?>
          </table>
        <?php } ?>
        

    <!-- TABLE: LATEST ORDERS -->
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('app', 'Recent Stocks Movement')?></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <?php $stocks = \app\models\Stocking::find()->where(['>=', 'created_at', date('Y-m-d')])->all(); 
            if ($stocks) { ?>
            <table class="table table-bordered table-responsive bg-white">
              <tr class="bg-aqua">
                <th width="35%"><?= Yii::t('app', 'Inventory')?></th>
                <th width="35%"><?= Yii::t('app', 'Item')?></th>
                <th width="15%"><?= Yii::t('app', 'Q')?></th>
              </tr>
            
          <?php    foreach ($stocks as $s) { 
          ?>
              <tr>
                <td width="35%"><?= Html::a($s->inventory->name , ['inventory/view', 'id' => $s->inventory->id])?></td>
                <td width="35%"><?=$s->product->product_name?></td>
                <?php if ($s->transaction == 'in') {?>
                <td width="15%"> <i style="color: red;" class="fa fa-arrow-circle-down"> </i>  <?=$s->quantity?></td>

                <?php }elseif ($s->transaction == 'out') {?>
                <td width="15%"> <?= Html::a('<i style="color: green;" class="fa fa-arrow-circle-up"> </i>' , ['invoices/view', 'id' => $s->invoproduct->invoice_id])?>  <?=$s->quantity?></td>
                <?php }elseif ($s->transaction == 'transfered') {
                  $ref = \app\models\Stocking::find()->where(['id' => $s->reference])->one();
                  // if ($ref) {
                  //   echo $ref['inventory_id'];
                  //   // var_dump($ref);
                  // }
                  // // print_r($ref);
                  // // echo $ref->id;
                ?>
                <td width="15%"> <?= Html::a('<i style="color: orange;" class="fa fa-arrow-circle-right"> </i>' , ['inventory/view', 'id' => $ref['inventory_id']])?>  <?=$s->quantity?></td>
                <?php }elseif ($s->transaction == 'returned'){?>
                <td width="15%"> <?= Html::a('<i style="color: purple;" class="fa fa-arrow-circle-down"> </i>' , ['invoices/view', 'id' => $s->invoproduct->invoice_id])?>  <?=$s->quantity?></td>
                <?php }?>
              </tr>  
          <?php }?>
            </table>
          <?php }?>
      </div>
      <!-- /.box-body -->
      <div class="box-footer clearfix">
        <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
        <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
      </div>
      <!-- /.box-footer -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->

  <div class="col-md-8 eArLangCss">
    <!-- MAP & BOX PANE -->
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('app', 'Outstanding Payments')?></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body no-padding">
        <div class="row">
          <div class="col-md-12">
            <div class="">
              <?php Pjax::begin(['id'=>'timeTable']); ?>
                 <?= \yii2fullcalendar\yii2fullcalendar::widget([        
                  'clientOptions' => [
                      'minTime'=> "08:00:00",
                      'maxTime'=> "18:59:59",
                      // 'defaultView' => 'agendaWeek',
                      // 'fixedWeekCount' => false,
                      // 'weekNumbers'=>true,
                      // 'editable' => true,
                      // 'selectable' => true,
                      // 'eventLimit' => true,
                      // 'eventLimitText' => '+ Lectures',
                      // 'selectHelper' => true,
                      'header' => [
                          'right' => 'month,agendaWeek,agendaDay',
                          'center' => 'title',
                          'left' => 'today prev,next'
                      ],
                      // 'select' =>  new \yii\web\JsExpression($JSEvent),
                      // 'eventClick' => new \yii\web\JsExpression($JSEventClick),
                      // 'eventRender' => new \yii\web\JsExpression($JsF),
                      // 'aspectRatio' => 2,
                      // 'timeFormat' => 'hh(:mm) A'
                  ],
                  'events' => Url::toRoute(['table'])
                ]); ?> 
            <?php Pjax::end();  ?>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->

  <!-- TABLE: LATEST ORDERS -->
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('app', 'Invoices')?></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="table-responsive">
          <?php echo $this->render('_invoices');?>
        </div>
        <!-- /.table-responsive -->
      </div>
      <!-- /.box-body -->
      <div class="box-footer clearfix">
        <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
        <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
      </div>
      <!-- /.box-footer -->
    </div>
    <!-- /.box -->
    
  </div>
  <!-- /.col -->


    


  
    
  
</div>
<!-- /.row -->
