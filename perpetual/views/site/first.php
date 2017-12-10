<!-- Info boxes -->
<div class="row">
  <div class="col-md-3 col-sm-6 col-xs-12 eArLangCss">
    <?php $sale = SystemAccount::find()->where(['account_no'=>'4000'])->one(); ?>
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="fa fa-shopping-cart"></i></span>

      <div class="info-box-content">
        <span class="info-box-text"><?= Yii::t('app', 'Total Sales')?></span>
        <span class="info-box-number">
          <?= $sale->balance?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs-12 eArLangCss">
    <?php $Inventory_value = SystemAccount::find()->where(['group'=>'inventory'])->sum('balance') ?>
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-shopping-basket"></i></span>

      <div class="info-box-content">
        <span class="info-box-text"><?= Yii::t('app', 'Cost of Goods')?></span>
        <span class="info-box-number"><?=$Inventory_value * Yii::$app->mycomponent->rate()?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

  <!-- fix for small devices only -->
  <div class="clearfix visible-sm-block"></div>

  <div class="col-md-3 col-sm-6 col-xs-12 eArLangCss">
    <?php $cash = SystemAccount::find()->where(['group'=>'cash'])->sum('balance') ?>
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-dollar"></i></span>

      <div class="info-box-content">
        <span class="info-box-text"><?= Yii::t('app', 'Cash')?></span>
        <span class="info-box-number"><?=$cash?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs-12 eArLangCss">
    <?php $recievable = SystemAccount::find()->where(['group'=>'client'])->sum('balance') ?>
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-credit-card"></i></span>

      <div class="info-box-content">
        <span class="info-box-text"><?= Yii::t('app', 'Recievable')?></span>
        <span class="info-box-number"><?=$recievable?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->