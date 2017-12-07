<?php 
use yii\helpers\Html;
use app\models\SystemAccount;
use dosamigos\chartjs\ChartJs;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\Invoices;
use app\models\InvoiceProduct;



?> 

<!-- Info boxes -->
<div class="row">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <?php $sale = SystemAccount::find()->where(['account_no'=>'4000'])->one(); ?>
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="fa fa-shopping-cart"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Total Sales</span>
        <span class="info-box-number">
          <?= $sale->balance?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs-12">
    <?php $Inventory_value = SystemAccount::find()->where(['group'=>'inventory'])->sum('balance') ?>
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-shopping-basket"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Inventories</span>
        <span class="info-box-number"><?=$Inventory_value?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

  <!-- fix for small devices only -->
  <div class="clearfix visible-sm-block"></div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <?php $cash = SystemAccount::find()->where(['group'=>'cash'])->sum('balance') ?>
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-dollar"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Cash</span>
        <span class="info-box-number"><?=$cash?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs-12">
    <?php $recievable = SystemAccount::find()->where(['group'=>'client'])->sum('balance') ?>
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-credit-card"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Recievable</span>
        <span class="info-box-number"><?=$recievable?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
<div class="row">
  <div class="col-md-12">
    <div class="box">
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
<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Sales Gross</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <div class="btn-group">
            <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-wrench"></i></button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li class="divider"></li>
              <li><a href="#">Separated link</a></li>
            </ul>
          </div>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-8">
            <p class="text-center">
              <strong>Sales to: <?= date('y-m-d')?></strong>
            </p>

            <div class="chart">
              <!-- Sales Chart Canvas -->
              <?= ChartJs::widget([
                'type' => 'line',
                'options' => [
                    'height' => 300,
                    // 'width' => 400
                ],
                'data' => [
                    'labels' => ["January", "February", "March", "April", "May", "June", "July"],
                    'datasets' => [
                        [
                            'label' => "Sales Gross",
                            'backgroundColor' => "rgba(179,181,198,0.2)",
                            'borderColor' => "rgba(179,181,198,1)",
                            'pointBackgroundColor' => "rgba(179,181,198,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(179,181,198,1)",
                            'data' => [65, 59, 90, 81, 56, 55, 40]
                        ],
                        [
                            'label' => "Sales Expenses",
                            'backgroundColor' => "rgba(255,99,132,0.2)",
                            'borderColor' => "rgba(255,99,132,1)",
                            'pointBackgroundColor' => "rgba(255,99,132,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(255,99,132,1)",
                            'data' => [28, 48, 40, 19, 96, 27, 100]
                        ]
                    ]
                ]
            ]);
            ?>
            </div>
            <!-- /.chart-responsive -->
          </div>
          <!-- /.col -->
          <div class="col-md-4">
            <p class="text-center">
              <strong>Goal Completion</strong>
            </p>

            <div class="progress-group">
              <span class="progress-text">Add Products to Cart</span>
              <span class="progress-number"><b>160</b>/200</span>

              <div class="progress sm">
                <div class="progress-bar progress-bar-aqua" style="width: 80%"></div>
              </div>
            </div>
            <!-- /.progress-group -->
            <div class="progress-group">
              <span class="progress-text">Complete Purchase</span>
              <span class="progress-number"><b>310</b>/400</span>

              <div class="progress sm">
                <div class="progress-bar progress-bar-red" style="width: 80%"></div>
              </div>
            </div>
            <!-- /.progress-group -->
            <div class="progress-group">
              <span class="progress-text">Visit Premium Page</span>
              <span class="progress-number"><b>480</b>/800</span>

              <div class="progress sm">
                <div class="progress-bar progress-bar-green" style="width: 80%"></div>
              </div>
            </div>
            <!-- /.progress-group -->
            <div class="progress-group">
              <span class="progress-text">Send Inquiries</span>
              <span class="progress-number"><b>250</b>/500</span>

              <div class="progress sm">
                <div class="progress-bar progress-bar-yellow" style="width: 80%"></div>
              </div>
            </div>
            <!-- /.progress-group -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- ./box-body -->
      <div class="box-footer">
        <div class="row">
          <div class="col-sm-3 col-xs-6">
            <div class="description-block border-right">
              <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> </span>
              <h5 class="description-header">$<?= $sale->balance?></h5>
              <span class="description-text">TOTAL REVENUE</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <?php $expenses = SystemAccount::find()->where(['group'=>'inventory expense'])->sum('balance') ?>
          <div class="col-sm-3 col-xs-6">
            <div class="description-block border-right">
              <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i><?= round($sale->balance-$expenses/100*$sale->balance)?>%</span>
              <h5 class="description-header">$<?= $expenses?></h5>
              <span class="description-text">TOTAL COST</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <?php $returns = SystemAccount::find()->where(['account_no'=>'4100'])->one() ?>
          <div class="col-sm-3 col-xs-6">
            <div class="description-block border-right">
              <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 20%</span>
              <h5 class="description-header">$<?=$returns->balance?></h5>
              <span class="description-text">SALES RETURN</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-3 col-xs-6">
            <div class="description-block">
              <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 18%</span>
              <h5 class="description-header"><?= $sale->balance-$expenses-$returns->balance?></h5>
              <span class="description-text">NET SALES</span>
            </div>
            <!-- /.description-block -->
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-footer -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
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

    <!-- PRODUCT LIST -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('app', 'Items Warning')?></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <?php $minimals = \app\models\Minimal::find()->all(); 
          if ($minimals) {
            foreach ($minimals as $product) { 
        ?>
        
          <div class="col-sm-6 eArLangCss"><?=$product->stock->product_name?></div>
          <div class="col-sm-6 eArLangCss"><?=$product->quantity?></div>
        
        <?php 
                }
              }
        ?>
        </div>
      <!-- /.box-body -->
      <div class="box-footer text-center">
       <?php // Html::a(Yii::t('app', 'View Products'), ['create'], ['class' => 'btn btn-success']) ?>
      </div>
      <!-- /.box-footer -->
    </div>
    <!-- /.box -->

    <!-- TABLE: LATEST ORDERS -->
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Stocks </h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="table-responsive">
          <table class="table no-margin">
            <thead>
            <tr>
              <th>Order ID</th>
              <th>Item</th>
              <th>Status</th>
              <th>Popularity</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td><a href="pages/examples/invoice.html">OR9842</a></td>
              <td>Call of Duty IV</td>
              <td><span class="label label-success">Shipped</span></td>
              <td>
                <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
              </td>
            </tr>
            <tr>
              <td><a href="pages/examples/invoice.html">OR1848</a></td>
              <td>Samsung Smart TV</td>
              <td><span class="label label-warning">Pending</span></td>
              <td>
                <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
              </td>
            </tr>
            <tr>
              <td><a href="pages/examples/invoice.html">OR7429</a></td>
              <td>iPhone 6 Plus</td>
              <td><span class="label label-danger">Delivered</span></td>
              <td>
                <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
              </td>
            </tr>
            <tr>
              <td><a href="pages/examples/invoice.html">OR7429</a></td>
              <td>Samsung Smart TV</td>
              <td><span class="label label-info">Processing</span></td>
              <td>
                <div class="sparkbar" data-color="#00c0ef" data-height="20">90,80,-90,70,-61,83,63</div>
              </td>
            </tr>
            <tr>
              <td><a href="pages/examples/invoice.html">OR1848</a></td>
              <td>Samsung Smart TV</td>
              <td><span class="label label-warning">Pending</span></td>
              <td>
                <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
              </td>
            </tr>
            <tr>
              <td><a href="pages/examples/invoice.html">OR7429</a></td>
              <td>iPhone 6 Plus</td>
              <td><span class="label label-danger">Delivered</span></td>
              <td>
                <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
              </td>
            </tr>
            <tr>
              <td><a href="pages/examples/invoice.html">OR9842</a></td>
              <td>Call of Duty IV</td>
              <td><span class="label label-success">Shipped</span></td>
              <td>
                <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
              </td>
            </tr>
            </tbody>
          </table>
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
        <h3 class="box-title">Invoices</h3>

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
