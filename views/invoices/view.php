<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

use app\models\SystemAccount;
use app\models\OutStanding;



/* @var $this yii\web\View */
/* @var $model app\models\Invoices */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('invo', 'Invoices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

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


<div class="invoices-view">
	<h1></h1>
	



	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<div >
				<?php 
					if($creditMax > 0){
				        echo Html::button('<i class="fa fa-2x fa-dollar"></i>', ['value' => Url::to(['cash', 'id' => $model->id]), 'title' => Yii::t('invo', 'Cash') , 'class' => 'btn btn-sm bg-purple showModalButton']); 
				        
				        echo " ".Html::button('<i class="fa fa-2x fa-money"></i>', ['value' => Url::to(['promise', 'id' => $model->id]), 'title' => Yii::t('invo', 'Promise'), 'class' => 'btn btn-sm bg-orange showModalButton']); 
				        echo " ".Html::button('<i class="fa fa-2x fa-bank"></i>', ['value' => Url::to(['cheque', 'id' => $model->id]), 'title' => Yii::t('invo', 'Cheque'), 'class' => 'btn btn-sm bg-navy showModalButton']); 
					}
				?>
				<?= Html::button('<i class="fa fa-2x fa-edit"></i>', ['value' => Url::to(['invoices/update', 'id' => $model->id]), 'title' => Yii::t('invo', 'Return'), 'class' => 'btn btn-flat btn-sm bg-maroon showModalButton']); ?>

       			<?= Html::a('<i class="fa fa-2x fa-print"></i>', ['print', 'id' => $model->id], 
       				[
       				'class' => 'btn btn-sm bg-olive',
       				'target'=>'_blank', 
				    'data-toggle'=>'tooltip', 
				    'title'=>'Will open the generated PDF file in a new window'
       				]) ?>

				<?php //echo  Html::button('<i class="fa fa-2x fa-print"></i>', ['value' => Url::to(['print', 'id' => $model->id]), 'title' => Yii::t('invo', 'Print'), 'class' => 'btn btn-sm bg-olive']);?>
			</div>
			<div class="box box-info">
				<div class="box-tools">
		          <button type="button" class="btn btn-sm btn-box-tool" data-widget="collapse"><i class="fa fa-2x fa-minus"></i>
		          </button>
		          <button type="button" class="btn btn-sm btn-box-tool" data-widget="remove"><i class="fa fa-2x fa-times"></i></button>
		        </div>
						
				<div class="box-body" style="min-height: 800px; height: auto;  box-shadow: 0 0 30px black; padding: 0 15px 0 15px;">
					<div class="col-sm-8 eArLangCss" style="min-height: 400px; height: auto;">
						<h1 style="text-align: center; margin: 30px; font-size: 40px; font-family: e; font-weight: bold;">
							<?= Yii::t('invo', 'Invoice') ." #". $model->id?> 
						</h1>
						<span class="text-bold"></span>
						<span class="text-bold"> <?= $model->created_at?></span>
						<hr style="margin-top: 0px; margin-bottom: 0px; border-top: 3px solid #ddd" >
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
									<td style="width: 30%"><?=$o->cheque_date?></td>
									<?php }else{?>
									<td style="width: 30%"><?=$o->due_date?></td>
									<?php }?>
									<td style="width: 20%"><?=$o->type?></td>
									<td style="width: 20%"><?=$o->amount?></td>
									
									<td>
										<?php 
											$cash = SystemAccount::find()->where(['group' => 'cash'])->one();
											$class = " fa fa-money";
											echo Html::a(Yii::t('invo', ''), ['reconcile', 'account_id' => $cash->id, 'invoice_id' =>$model->id, 'outstanding_id' => $o->id], ['class' => $class]);
										?>
										<span class="dropdown">
										  <span class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
										    <span class="fa fa-bank" style="color: gray; "></span>
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
					<div class="col-sm-4 eArLangCss" style="min-height: 400px; padding-left: 0; padding-right: 0;">
						<div class="col-sm-12" style="min-height: 180px;">
				            <div style="margin-top: 40px; margin-left: 20px;">
				              	<h3 style="font-weight: bold; color: brown;">
				              		
				              	</h3>
				
				              	<p></p>
				             	<p> </p>
				            </div>
						</div>
						<div class="col-sm-12" style="min-height: 180px; border-top:2px solid #ecf0f5">
							<div class="col-sm-12" style="min-height: 180px;">
					            <div style="margin-top: 40px; margin-left: 20px;">
					              	<h3 style="font-weight: bold; color: brown;">
					              		<?= $model->client->client_name;?>
					              	</h3>
					
					              	<p><?= $model->client->address;?></p>
					             	<p> <?= $model->client->phone;?></p>
					            </div>
							</div>

						</div>
					</div>


					<div style="margin:70px"></div>

					<table class="table table-responsive">
								<tr class="bg-aqua">
									<th style="width: 2%; color: white;"></th>
									<th style="width: 40%; color: white;"><?= Yii::t('invo', 'Item')?></th>
									<th style="width: 10%; color: white;"><?= Yii::t('invo', 'Quantity')?></th>
									<th style="width: 10%; color: white;"><?= Yii::t('invo', 'Price')?></th>
									<th style="width: 10%; color: white;"><?= Yii::t('invo', 'Discount')?></th>
									<th style="width: 20%; color: white;"><?= Yii::t('invo', 'LineTotal')?></th>
								</tr>
								<?php 
									$products = $model->invoiceProducts;
									foreach ($products as $product => $p) { 
								?>
								<tr>
									<td style="width: 2%"><?= $product+1 ?></td>
									<td style="width: 40%"><?=$p->product->product_name?></td>
									<td style="width: 10%"><?=$p->quantity?></td>
									<td style="width: 10%"><?=$p->selling_rate?></td>
									<td style="width: 10%"><?=$p->discount?></td>
									<td style="width: 20%"><?= $p->quantity * $p->selling_rate - $p->discount?>.00</td>
									
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

								<tr style="border-bottom: 2px solid #ddd;">
									<td></td>	
									<td></td>	
									<td></td>	
									<td></td>	
									<td ><?= Yii::t('invo', 'SUBTOTAL')?>: </td>
									<td > $<?= $model->amount?> </td>
								</tr>
								<tr>
									<td style="border-top: 0;  border-bottom:0;"></td>	
									<td style="border-top: 0;  border-bottom:0;"></td>	
									<td style="border-top: 0;  border-bottom:0;"></td>	
									<td style="border-top: 0;  border-bottom:0;"></td>	
									<td style="border-top: 0;  border-bottom:0;"><?= Yii::t('invo', 'TAX')?>: </td>
									<td style="border-top: 0;  border-bottom:0;"> 0.00% </td>
								</tr>
								<tr>
									<td style="border-top: 0;  border-bottom:0;"></td>	
									<td style="border-top: 0;  border-bottom:0;"></td>	
									<td style="border-top: 0;  border-bottom:0;"></td>	
									<td style="border-top: 0;  border-bottom:0;"></td>	
									<td style="border-top: 0;  border-bottom:0; font-weight: bold;"><?= Yii::t('invo', 'TOTAL')?>: </td>
									<td style="border-top: 0;  border-bottom:0; font-weight: bold;"> $<?= $model->amount?> </td>
								</tr>

								<tr style="border-bottom: 2px solid #000;">
									<td style="border-top: 0;  border-bottom:0;"></td>	
									<td style="border-top: 0;  border-bottom:0;"></td>	
									<td style="border-top: 0;  border-bottom:0;"></td>	
									<td style="border-top: 0;  border-bottom:0;"></td>	
									<td style="border-top: 0;  border-bottom:0; "><?= Yii::t('invo', 'PAID')?>: </td>
									<td style="border-top: 0;  border-bottom:0; "> $<?= $total_paid?>.00</td>
								</tr>

								<tr>
									<td style="border-top: 0;  border-bottom:0;"></td>	
									<td style="border-top: 0;  border-bottom:0;"></td>	
									<td style="border-top: 0;  border-bottom:0;"></td>	
									<td style="border-top: 0;  border-bottom:0;"></td>	
									<td style="border-bottom: 4px solid #ddd; font-weight: bold; width: 30%"><?= Yii::t('invo', 'AMOUNT DUE')?>: </td>
									<td style="border-bottom: 4px solid #ddd; font-weight: bold;"> $<?= $remaining?>.00 </td>
								</tr>

					</table>
					
				</div>
			</div>
		<div class="box box-success">
		  	<div class="box-tools">
	          <button type="button" class="btn btn-sm btn-box-tool" data-widget="collapse"><i class="fa fa-2x fa-minus"></i>
	          </button>
	          <button type="button" class="btn btn-sm btn-box-tool" data-widget="remove"><i class="fa fa-2x fa-times"></i></button>
	        	
	        </div>

	        <div class="box-body" >
	        	<div class="col-sm-6 eArLangCss">
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
							<td ><?=Yii::$app->formatter->asDecimal($payment->amount, 2)?></td>
							<td ><?= Yii::t('invo', $payment->mode)?> </td>
							<td ><?= Yii::$app->formatter->asDatetime($payment->created_at) ?></td>
							
						</tr>
						<?php } 

						?>
					</table>
		  		</div>
		  		<div class="col-sm-6 eArLangCss">
		  			<table class="table table-responsive">
								<tr class="<?=$model->client->color_class?>">
									<th style="width: 2%; color: white;"></th>
									<th style="width: 40%; color: white;"><?= Yii::t('invo', 'Item')?></th>
									<th style="width: 10%; color: white;"><?= Yii::t('invo', 'Quantity')?></th>
									<th style="width: 10%; color: white;"><?= Yii::t('invo', 'Price')?></th>
									<th style="width: 20%; color: white;"><?= Yii::t('invo', 'LineTotal')?></th>
								</tr>
								<?php 
									$products = $model->invoiceReturnedProducts;
									foreach ($products as $product => $p) { 
								?>
								<tr>
									<td style="width: 2%"><?= $product+1 ?></td>
									<td style="width: 40%"><?=$p->product->product_name?></td>
									<td style="width: 10%"><?=$p->quantity?></td>
									<td style="width: 10%"><?=$p->selling_rate?></td>
									<td style="width: 20%"><?= $p->quantity * $p->selling_rate?>.00</td>
									
								</tr>
								<?php } 

								?>
								

					</table>
		  		</div> 
			</div>
		</div>
		</div>
	</div>
	
</div>
