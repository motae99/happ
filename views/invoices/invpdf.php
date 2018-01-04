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
<div class="all">
	<div class="col-lg-8 eArLangCss ">
		<h1 class="centerize">
			<?= Yii::t('invo', 'Invoice') ." #". $model->id?> 
		</h1>
		<span class="text-bold"></span>
		<span class="text-bold"> <?= Yii::$app->formatter->asDate($model->created_at) ?></span>
		<hr>
		<?php if($outstandings){ ?>
			<div class="col-lg-10">
			<table class="table">
				<tr>
					<th>#</th>
					<th><?= Yii::t('invo', 'Due Date')?></th>
					<th><?= Yii::t('invo', 'Type')?></th>
					<th><?= Yii::t('invo', 'Amount')?></th>
					<th><span class="fa fa-check"><span></th>
				</tr>
				<?php foreach ($outstandings as $o) { ?>
				<tr>
					<td><?=Html::a(Yii::t('invo', ''), ['reconcile-delete', 'id' => $o->id], ['class' => 'fa fa-remove'])?></td>
					<?php if($o->type == 'cheque'){?>
					<td ><?=Yii::$app->formatter->asDate($o->cheque_date) ?></td>
					<?php }else{?>
					<td ><?=Yii::$app->formatter->asDate($o->due_date)?></td>
					<?php }?>
					<td ><?=$o->type?></td>
					<td ><?=Yii::$app->formatter->asDecimal($o->amount) ?></td>
					<td></td>
				</tr>
				<?php } ?> 
			</table>
			</div>
			<?php }?>
	</div>
	<div class="col-lg-4 eArLangCss" >
		<div class="padding" >
            <div >
              	<h4 class="textcolor">
              		<?=Yii::$app->mycomponent->name();?>
              	</h4>

              	<p><?=Yii::$app->mycomponent->address();?></p>
             	<p><?=Yii::$app->mycomponent->phone();?></p>
            </div>
		</div>
		<div class="padding client" >
            <div >
            	<span class="textcolor2">
            	<?=Yii::t('invo', 'Bill to' )?>
              	</span>
              	<h4 >
              		<?= $model->client->client_name;?>
              	</h4>

              	<p><?= $model->client->address;?></p>
             	<p> <?= $model->client->phone;?></p>
            </div>
		</div>
	</div>
	</div>



	<table class="table table-responsive">
				<tr class="trcolor">
					<th class="th1"></th>
					<th class="th2"><?= Yii::t('invo', 'Item')?></th>
					<th class="th3"><?= Yii::t('invo', 'Quantity')?></th>
					<th class="th4"><?= Yii::t('invo', 'Price')?></th>
					<th class="th5"><?= Yii::t('invo', 'Discount')?></th>
					<th class="th6"><?= Yii::t('invo', 'LineTotal')?></th>
				</tr>
				<?php 
					$products = $model->invoiceProducts;
					foreach ($products as $product => $p) { 
				?>
				<tr>
					<td><?= Yii::$app->formatter->asDecimal($product+1)  ?></td>
					<td ><?=$p->product->product_name?></td>
					<td ><?=Yii::$app->formatter->asDecimal($p->quantity)?></td>
					<td ><?=Yii::$app->formatter->asDecimal($p->selling_rate)?></td>
					<td ><?=$p->discount?></td>
					<td class="td6"><?= Yii::$app->formatter->asDecimal($p->quantity * $p->selling_rate - $p->discount) ?></td>
					
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
					<td class="hrline linefirst"></td>	
					<td class="hrline linefirst"></td>	
					<td class="hrline linefirst"></td>	
					<td class="hrline linefirst"></td>	
					<td class="hrline linefirst"><?= Yii::t('invo', 'SUBTOTAL')?>: </td>
					<td class="hrline linefirst tdd6"> <?=Yii::$app->formatter->asDecimal($model->amount)?> </td>
				</tr>
				<tr>
					<td class="hrline"></td>	
					<td class="hrline"></td>	
					<td class="hrline"></td>	
					<td class="hrline"></td>	
					<td class="hrline"><?= Yii::t('invo', 'TAX')?>: </td>
					<td class="hrline tdd6"> <?=Yii::$app->formatter->asDecimal(0, 2)?>% </td>
				</tr>
				<tr>
					<td class="hrline"></td>	
					<td class="hrline"></td>	
					<td class="hrline"></td>	
					<td class="hrline"></td>	
					<td class="hrline"><?= Yii::t('invo', 'TOTAL')?>: </td>
					<td class="hrline tdd6"> <?=Yii::$app->formatter->asDecimal($model->amount) ?> </td>
				</tr>

				<tr >
					<td class="hrline linesecond "></td>	
					<td class="hrline linesecond "></td>	
					<td class="hrline linesecond "></td>	
					<td class="hrline linesecond "></td>	
					<td class="hrline linesecond "><?= Yii::t('invo', 'PAID')?>: </td>
					<td class="hrline linesecond tdd6"> <?=Yii::$app->formatter->asDecimal($total_paid) ?></td>
				</tr>

				<tr class="hrline">
					<td class="hrline "></td>	
					<td class="hrline "></td>	
					<td class="hrline "></td>	
					<td class="hrline "></td>	
					<td class="hrline bottom"><?= Yii::t('invo', 'AMOUNT DUE')?>: </td>
					<td class="hrline tdd6 bottom"> <?= Yii::$app->formatter->asDecimal($remaining) ?> </td>
				</tr>
	</table>	
</div>
		
