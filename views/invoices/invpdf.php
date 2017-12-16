<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

use app\models\SystemAccount;
use app\models\OutStanding;


?>

<?php 
	$paid = $model->payments;
    $total_paid = 0;
    if($paid){
        foreach ($paid as $p) {
            $total_paid += $p->amount ;
        }
    }
    $remaining = $model->amount - $total_paid ;

    $outstandings = $model->outstanding;
    $credit = 0;
    if($outstandings){
        foreach ($outstandings as $o) {
            $credit += $o->amount ;
        }
    }

    $creditMax = $remaining - $credit ;
?> 

<!-- <div class="box box-info">
	<div class="box-tools">
      <button type="button" class="btn btn-sm btn-box-tool" data-widget="collapse"><i class="fa fa-2x fa-minus"></i>
      </button>
      <button type="button" class="btn btn-sm btn-box-tool" data-widget="remove"><i class="fa fa-2x fa-times"></i></button>
    </div> -->
			
	<div class="box-body">
		<div class="col-sm-8 eArLangCss" >
			<h1 >
				<?= Yii::t('invo', 'Invoice') ." #". $model->id?> 
			</h1>
			<span class="text-bold"></span>
			<span class="text-bold"> <?= $model->created_at?></span>
			<hr >
			<?php if($outstandings){ ?>
				<table class="table table-border table-responsive">
					<tr>
						<th>#</th>
						<th><?= Yii::t('invo', 'Due Date')?></th>
						<th><?= Yii::t('invo', 'Type')?></th>
						<th><?= Yii::t('invo', 'Total')?></th>
						<th><span class="fa fa-check"><span></th>
					</tr>
					<?php foreach ($outstandings as $o) { ?>
					<tr>
						<td><?=Html::a(Yii::t('invo', ''), ['reconcile-delete', 'id' => $o->id], ['class' => 'fa fa-remove'])?></td>
						<?php if($o->type == 'cheque'){?>
						<td ><?=$o->cheque_date?></td>
						<?php }else{?>
						<td ><?=$o->due_date?></td>
						<?php }?>
						<td ><?=$o->type?></td>
						<td ><?=$o->amount?></td>
						
						<td>
							<?php 
								$cash = SystemAccount::find()->where(['group' => 'cash'])->one();
								$class = " fa fa-money";
								echo Html::a(Yii::t('invo', ''), ['reconcile', 'account_id' => $cash->id, 'invoice_id' =>$model->id, 'outstanding_id' => $o->id], ['class' => $class]);
							?>
							<span class="dropdown">
							  <span class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
							    <span class="fa fa-bank" ></span>
							  </span>

							  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
							  	<?php 
							  		$banks = SystemAccount::find()->where(['group' => 'cash bank'])->all();
							  		if($banks){
							  			foreach ($banks as $bank) {
							  				$class = $bank->color_class." btn btn-block";
							  	?>
							    <li role="presentation" ><?= Html::a(Yii::t('invo', $bank->system_account_name), ['reconcile', 'account_id' => $bank->id, 'invoice_id' =>$model->id, 'outstanding_id' => $o->id], ['class' => $class, 'role' => 'menuitem']) ?></li>
							  	
							  	<?php			
							  			}
							  		}
							  	?>
							  </ul>
						    </span>
						</td>
					</tr>
					<?php } ?> 
				</table>
				<?php }?>
		</div>
		<div class="col-sm-4 eArLangCss" >
			<div class="col-sm-12" >
	            <div >
	              	<h3 >
	              		
	              	</h3>
	
	              	<p></p>
	             	<p> </p>
	            </div>
			</div>
			<div class="col-sm-12" >
				<div class="col-sm-12" >
		            <div >
		              	<h3 >
		              		<?= $model->client->client_name;?>
		              	</h3>
		
		              	<p><?= $model->client->address;?></p>
		             	<p> <?= $model->client->phone;?></p>
		            </div>
				</div>

			</div>
		</div>


		<div ></div>

		<table class="table table-responsive">
					<tr class="bg-aqua">
						<th ></th>
						<th ><?= Yii::t('invo', 'Item')?></th>
						<th ><?= Yii::t('invo', 'Quantity')?></th>
						<th ><?= Yii::t('invo', 'Price')?></th>
						<th ><?= Yii::t('invo', 'Discount')?></th>
						<th ><?= Yii::t('invo', 'LineTotal')?></th>
					</tr>
					<?php 
						$products = $model->invoiceProducts;
						foreach ($products as $product => $p) { 
					?>
					<tr>
						<td><?= $product+1 ?></td>
						<td ><?=$p->product->product_name?></td>
						<td ><?=$p->quantity?></td>
						<td ><?=$p->selling_rate?></td>
						<td ><?=$p->discount?></td>
						<td ><?= $p->quantity * $p->selling_rate - $p->discount?>.00</td>
						
					</tr>
					<?php } 

					?>
					<tr>
						<td>#</td>	
						<td></td>	
						<td></td>	
						<td></td>	
						<td></td>
						<td></td>
					</tr>

					<tr >
						<td></td>	
						<td></td>	
						<td></td>	
						<td></td>	
						<td ><?= Yii::t('invo', 'SUBTOTAL')?>: </td>
						<td > $<?= $model->amount?> </td>
					</tr>
					<tr>
						<td ></td>	
						<td ></td>	
						<td ></td>	
						<td ></td>	
						<td ><?= Yii::t('invo', 'TAX')?>: </td>
						<td > 0.00% </td>
					</tr>
					<tr>
						<td ></td>	
						<td ></td>	
						<td ></td>	
						<td ></td>	
						<td ><?= Yii::t('invo', 'TOTAL')?>: </td>
						<td > $<?= $model->amount?> </td>
					</tr>

					<tr >
						<td ></td>	
						<td ></td>	
						<td ></td>	
						<td ></td>	
						<td ><?= Yii::t('invo', 'PAID')?>: </td>
						<td > $<?= $total_paid?>.00</td>
					</tr>

					<tr>
						<td ></td>	
						<td ></td>	
						<td ></td>	
						<td ></td>	
						<td ><?= Yii::t('invo', 'AMOUNT DUE')?>: </td>
						<td > $<?= $remaining?>.00 </td>
					</tr>

		</table>

		
	</div>
		
<!-- </div> -->