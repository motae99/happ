<div class="col-sm-12">
  <div class="col-sm-8 eArLangCss">
    <table class="table table-bordered table-responsive">
        <tr class="<?=$model->client->color_class?>">
          <th style="color: white;"></th>
          <th style="color: white;"><?= Yii::t('invo', 'Item')?></th>
          <th style="color: white;"><?= Yii::t('invo', 'Quantity')?></th>
          <th style="color: white;"><?= Yii::t('invo', 'Price')?></th>
          <th style="color: white;"><?= Yii::t('invo', 'LineTotal')?></th>
        </tr>
          <?php 
            $products = $model->invoiceProductsAll;
            foreach ($products as $product => $p) {
            if ($p->returned == 0) {
              echo "<tr class='bg-green'>";
            }else{
              echo "<tr class='bg-red'>";
            }
        
          ?>
          <td><?= $product+1 ?></td>
          <td><?=$p->product->product_name?></td>
          <td><?=$p->quantity?></td>
          <td><?=$p->selling_rate?></td>
          <td><?= $p->quantity * $p->selling_rate?>.00</td>
          
        </tr>
          <?php } 

          ?>
    </table>
  </div>

  <div class="col-sm-4 eArLangCss">
    <table class="table table-responsive">
      <tr class="<?=$model->client->color_class?>">
        <th style="color: white;"><?= Yii::t('invo', 'Amount')?></th>
        <th style="color: white;"><?= Yii::t('invo', 'Mode')?></th>
        <th style="color: white;"><?= Yii::t('invo', 'Paid At')?></th>
      </tr>
        <?php 
          $payments = $model->payments;
          foreach ($payments as $payment ) { 
        ?>
      <tr>
        <td ><?=$payment->amount?></td>
        <td ><?=$payment->mode?></td>
        <td ><?=$payment->created_at?></td>
        
      </tr>
        <?php } 

        ?>
    </table>
  </div>
 
</div>