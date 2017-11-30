<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\SystemAccount;
use dosamigos\chartjs\ChartJs;

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
  <div class="col-md-4">
    <!-- Info Boxes Style 2 -->
   

  <?php $dues = \app\models\Outstanding::find()->where(['due_date'=> date('Y-m-d')])->Orwhere(['cheque_date' => date('Y-m-d')])->all(); 
        if ($dues) {
          foreach ($dues as $due) { ?>

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
    
    
    <!-- /.box -->

    <!-- PRODUCT LIST -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Items Minimal</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <ul class="products-list product-list-in-box">
          <li class="item">
            <div class="product-img">
              <img src="dist/img/default-50x50.gif" alt="Product Image">
            </div>
            <div class="product-info">
              <a href="javascript:void(0)" class="product-title">Samsung TV
                <span class="label label-warning pull-right">$1800</span></a>
              <span class="product-description">
                    Samsung 32" 1080p 60Hz LED Smart HDTV.
                  </span>
            </div>
          </li>
          <!-- /.item -->
          <li class="item">
            <div class="product-img">
              <img src="dist/img/default-50x50.gif" alt="Product Image">
            </div>
            <div class="product-info">
              <a href="javascript:void(0)" class="product-title">Bicycle
                <span class="label label-info pull-right">$700</span></a>
              <span class="product-description">
                    26" Mongoose Dolomite Men's 7-speed, Navy Blue.
                  </span>
            </div>
          </li>
          <!-- /.item -->
          <li class="item">
            <div class="product-img">
              <img src="dist/img/default-50x50.gif" alt="Product Image">
            </div>
            <div class="product-info">
              <a href="javascript:void(0)" class="product-title">Xbox One <span
                  class="label label-danger pull-right">$350</span></a>
              <span class="product-description">
                    Xbox One Console Bundle with Halo Master Chief Collection.
                  </span>
            </div>
          </li>
          <!-- /.item -->
          <li class="item">
            <div class="product-img">
              <img src="dist/img/default-50x50.gif" alt="Product Image">
            </div>
            <div class="product-info">
              <a href="javascript:void(0)" class="product-title">PlayStation 4
                <span class="label label-success pull-right">$399</span></a>
              <span class="product-description">
                    PlayStation 4 500GB Console (PS4)
                  </span>
            </div>
          </li>
          <!-- /.item -->
        </ul>
      </div>
      <!-- /.box-body -->
      <div class="box-footer text-center">
        <a href="javascript:void(0)" class="uppercase">View All Products</a>
      </div>
      <!-- /.box-footer -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->

  <div class="col-md-8">
    <!-- MAP & BOX PANE -->
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Outstanding Payments</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body no-padding">
        <div class="row">
          <div class="col-md-9 col-sm-8">
            <div class="">
              <?php 
                $events = array();
                //Testing
                $Event = new \yii2fullcalendar\models\Event();
                $Event->id = 1;
                $Event->title = 'Testing';
                $Event->start = date('Y-m-d\TH:i:s\Z');
                // $event->nonstandard = [
                //   'field1' => 'Something I want to be included in object #1',
                //   'field2' => 'Something I want to be included in object #2',
                // ];
                $events[] = $Event;

                $Event = new \yii2fullcalendar\models\Event();
                $Event->id = 2;
                $Event->title = 'Testing';
                $Event->start = date('Y-m-d\TH:i:s\Z',strtotime('tomorrow 6am'));
                $events[] = $Event;
              ?>
              <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
                      'options' => [
                        'height' => 200,
                        'columnHeader'=> false,
                        //... more options to be defined here!
                      ],
                      'events'=> $events,
                  ));
              ?>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-4">
            <div class="pad box-pane-right bg-green" style="min-height: 280px">
              <div class="description-block margin-bottom">
                <div class="sparkbar pad" data-color="#fff">a</div>
                <h5 class="description-header">8390</h5>
                <span class="description-text">Today</span>
              </div>
              <!-- /.description-block -->
              <div class="description-block margin-bottom">
                <div class="sparkbar pad" data-color="#fff">a</div>
                <h5 class="description-header">30%</h5>
                <span class="description-text">This Week</span>
              </div>
              <!-- /.description-block -->
              <div class="description-block">
                <div class="sparkbar pad" data-color="#fff">a</div>
                <h5 class="description-header">70%</h5>
                <span class="description-text">This month</span>
              </div>
              <!-- /.description-block -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
    <div class="row">
      <div class="col-md-6">
        <!-- DIRECT CHAT -->
        <div class="box box-warning direct-chat direct-chat-warning">
          <div class="box-header with-border">
            <h3 class="box-title">Direct Chat</h3>

            <div class="box-tools pull-right">
              <span data-toggle="tooltip" title="3 New Messages" class="badge bg-yellow">3</span>
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts"
                      data-widget="chat-pane-toggle">
                <i class="fa fa-comments"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <!-- Conversations are loaded here -->
            <div class="direct-chat-messages">
              <!-- Message. Default to the left -->
              <div class="direct-chat-msg">
                <div class="direct-chat-info clearfix">
                  <span class="direct-chat-name pull-left">Alexander Pierce</span>
                  <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                </div>
                <!-- /.direct-chat-info -->
                <img class="direct-chat-img" src="dist/img/user1-128x128.jpg" alt="message user image">
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text">
                  Is this template really for free? That's unbelievable!
                </div>
                <!-- /.direct-chat-text -->
              </div>
              <!-- /.direct-chat-msg -->

              <!-- Message to the right -->
              <div class="direct-chat-msg right">
                <div class="direct-chat-info clearfix">
                  <span class="direct-chat-name pull-right">Sarah Bullock</span>
                  <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                </div>
                <!-- /.direct-chat-info -->
                <img class="direct-chat-img" src="dist/img/user3-128x128.jpg" alt="message user image">
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text">
                  You better believe it!
                </div>
                <!-- /.direct-chat-text -->
              </div>
              <!-- /.direct-chat-msg -->

              <!-- Message. Default to the left -->
              <div class="direct-chat-msg">
                <div class="direct-chat-info clearfix">
                  <span class="direct-chat-name pull-left">Alexander Pierce</span>
                  <span class="direct-chat-timestamp pull-right">23 Jan 5:37 pm</span>
                </div>
                <!-- /.direct-chat-info -->
                <img class="direct-chat-img" src="dist/img/user1-128x128.jpg" alt="message user image">
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text">
                  Working with AdminLTE on a great new app! Wanna join?
                </div>
                <!-- /.direct-chat-text -->
              </div>
              <!-- /.direct-chat-msg -->

              <!-- Message to the right -->
              <div class="direct-chat-msg right">
                <div class="direct-chat-info clearfix">
                  <span class="direct-chat-name pull-right">Sarah Bullock</span>
                  <span class="direct-chat-timestamp pull-left">23 Jan 6:10 pm</span>
                </div>
                <!-- /.direct-chat-info -->
                <img class="direct-chat-img" src="dist/img/user3-128x128.jpg" alt="message user image">
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text">
                  I would love to.
                </div>
                <!-- /.direct-chat-text -->
              </div>
              <!-- /.direct-chat-msg -->

            </div>
            <!--/.direct-chat-messages-->

            <!-- Contacts are loaded here -->
            <div class="direct-chat-contacts">
              <ul class="contacts-list">
                <li>
                  <a href="#">
                    <img class="contacts-list-img" src="dist/img/user1-128x128.jpg" alt="User Image">

                    <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Count Dracula
                            <small class="contacts-list-date pull-right">2/28/2015</small>
                          </span>
                      <span class="contacts-list-msg">How have you been? I was...</span>
                    </div>
                    <!-- /.contacts-list-info -->
                  </a>
                </li>
                <!-- End Contact Item -->
                <li>
                  <a href="#">
                    <img class="contacts-list-img" src="dist/img/user7-128x128.jpg" alt="User Image">

                    <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Sarah Doe
                            <small class="contacts-list-date pull-right">2/23/2015</small>
                          </span>
                      <span class="contacts-list-msg">I will be waiting for...</span>
                    </div>
                    <!-- /.contacts-list-info -->
                  </a>
                </li>
                <!-- End Contact Item -->
                <li>
                  <a href="#">
                    <img class="contacts-list-img" src="dist/img/user3-128x128.jpg" alt="User Image">

                    <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Nadia Jolie
                            <small class="contacts-list-date pull-right">2/20/2015</small>
                          </span>
                      <span class="contacts-list-msg">I'll call you back at...</span>
                    </div>
                    <!-- /.contacts-list-info -->
                  </a>
                </li>
                <!-- End Contact Item -->
                <li>
                  <a href="#">
                    <img class="contacts-list-img" src="dist/img/user5-128x128.jpg" alt="User Image">

                    <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Nora S. Vans
                            <small class="contacts-list-date pull-right">2/10/2015</small>
                          </span>
                      <span class="contacts-list-msg">Where is your new...</span>
                    </div>
                    <!-- /.contacts-list-info -->
                  </a>
                </li>
                <!-- End Contact Item -->
                <li>
                  <a href="#">
                    <img class="contacts-list-img" src="dist/img/user6-128x128.jpg" alt="User Image">

                    <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            John K.
                            <small class="contacts-list-date pull-right">1/27/2015</small>
                          </span>
                      <span class="contacts-list-msg">Can I take a look at...</span>
                    </div>
                    <!-- /.contacts-list-info -->
                  </a>
                </li>
                <!-- End Contact Item -->
                <li>
                  <a href="#">
                    <img class="contacts-list-img" src="dist/img/user8-128x128.jpg" alt="User Image">

                    <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Kenneth M.
                            <small class="contacts-list-date pull-right">1/4/2015</small>
                          </span>
                      <span class="contacts-list-msg">Never mind I found...</span>
                    </div>
                    <!-- /.contacts-list-info -->
                  </a>
                </li>
                <!-- End Contact Item -->
              </ul>
              <!-- /.contatcts-list -->
            </div>
            <!-- /.direct-chat-pane -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <form action="#" method="post">
              <div class="input-group">
                <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                <span class="input-group-btn">
                      <button type="button" class="btn btn-warning btn-flat">Send</button>
                    </span>
              </div>
            </form>
          </div>
          <!-- /.box-footer-->
        </div>
        <!--/.direct-chat -->
      </div>
      <!-- /.col -->

      <div class="col-md-6">
        <!-- USERS LIST -->
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Latest Members</h3>

            <div class="box-tools pull-right">
              <span class="label label-danger">8 New Members</span>
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body no-padding">
            <ul class="users-list clearfix">
              <li>
                <img src="dist/img/user1-128x128.jpg" alt="User Image">
                <a class="users-list-name" href="#">Alexander Pierce</a>
                <span class="users-list-date">Today</span>
              </li>
              <li>
                <img src="dist/img/user8-128x128.jpg" alt="User Image">
                <a class="users-list-name" href="#">Norman</a>
                <span class="users-list-date">Yesterday</span>
              </li>
              <li>
                <img src="dist/img/user7-128x128.jpg" alt="User Image">
                <a class="users-list-name" href="#">Jane</a>
                <span class="users-list-date">12 Jan</span>
              </li>
              <li>
                <img src="dist/img/user6-128x128.jpg" alt="User Image">
                <a class="users-list-name" href="#">John</a>
                <span class="users-list-date">12 Jan</span>
              </li>
              <li>
                <img src="dist/img/user2-160x160.jpg" alt="User Image">
                <a class="users-list-name" href="#">Alexander</a>
                <span class="users-list-date">13 Jan</span>
              </li>
              <li>
                <img src="dist/img/user5-128x128.jpg" alt="User Image">
                <a class="users-list-name" href="#">Sarah</a>
                <span class="users-list-date">14 Jan</span>
              </li>
              <li>
                <img src="dist/img/user4-128x128.jpg" alt="User Image">
                <a class="users-list-name" href="#">Nora</a>
                <span class="users-list-date">15 Jan</span>
              </li>
              <li>
                <img src="dist/img/user3-128x128.jpg" alt="User Image">
                <a class="users-list-name" href="#">Nadia</a>
                <span class="users-list-date">15 Jan</span>
              </li>
            </ul>
            <!-- /.users-list -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer text-center">
            <a href="javascript:void(0)" class="uppercase">View All Users</a>
          </div>
          <!-- /.box-footer -->
        </div>
        <!--/.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- TABLE: LATEST ORDERS -->
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Latest Orders</h3>

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

  
</div>
<!-- /.row -->
