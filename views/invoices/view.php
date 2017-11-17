<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

use app\models\SystemAccount;
use app\models\OutStanding;



/* @var $this yii\web\View */
/* @var $model app\models\Invoices */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Invoices'), 'url' => ['index']];
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
	<h1><?= Html::encode($this->title) ?></h1>
	<?php 
		if($creditMax > 0){
	        echo Html::button('<i class="glyphicon glyphicon-plus-sign"> Cash</i>', ['value' => Url::to(['cash', 'id' => $model->id]), 'title' => 'Cash', 'class' => 'btn btn-block bg-purple btn-flat margin showModalButton']); 
	        echo Html::button('<i class="glyphicon glyphicon-plus-sign"> Promise</i>', ['value' => Url::to(['promise', 'id' => $model->id]), 'title' => 'Promise', 'class' => 'btn btn-block bg-purple btn-flat margin showModalButton']); 
	        echo Html::button('<i class="glyphicon glyphicon-plus-sign">OutStanding Cheque</i>', ['value' => Url::to(['cheque', 'id' => $model->id]), 'title' => 'Cheque', 'class' => 'btn btn-block bg-purple btn-flat margin showModalButton']); 
		}
	?>
	<div class="col-sm-6">
		<table class="table table-bordered table-responsive">
			<tr>
				<th class="text-center">#</th>
				<th class="text-center">Amount</th>
				<th class="text-center">Type</th>
				<th class="text-center">Due Date</th>
				<th class="text-center">Reconcile</th>
			</tr>
			<?php
				if($outstandings){
			        foreach ($outstandings as $o) {
			?>
			<tr>
				<td class="text-center"><?=Html::a(Yii::t('app', ''), ['reconcile', 'outstanding_id' => $o->id], ['class' => 'fa fa-remove'])?></td>
				<td class="text-center"><?=$o->amount?></td>
				<td class="text-center"><?=$o->type?></td>
				<?php if($o->type == 'cheque'){?>
				<td class="text-center"><?=$o->cheque_date?></td>
				<?php }else{?>
				<td class="text-center"><?=$o->due_date?></td>
				<?php }?>
				
				<td class="text-center">
					<?php 
						$cash = SystemAccount::find()->where(['group' => 'cash'])->one();
						$class = " fa fa-money";
						echo Html::a(Yii::t('app', ''), ['reconcile', 'account_id' => $cash->id, 'invoice_id' =>$model->id, 'outstanding_id' => $o->id], ['class' => $class]);
					?>
					<span class="dropdown">
					  <span class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
					    <span class="fa fa-bank"></span>
					  </span>

					  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
					  	<?php 
					  		$banks = SystemAccount::find()->where(['group' => 'cash bank'])->all();
					  		if($banks){
					  			foreach ($banks as $bank) {
					  				$class = $bank->color_class." btn btn-block";
					  	?>
					    <li role="presentation" ><?= Html::a(Yii::t('app', $bank->system_account_name), ['reconcile', 'account_id' => $bank->id, 'invoice_id' =>$model->id, 'outstanding_id' => $o->id], ['class' => $class, 'role' => 'menuitem']) ?></li>
					  	
					  	<?php			
					  			}
					  		}
					  	?>
					  </ul>
				    </span>
				</td>
			</tr>
			<?php
			        }
			    }  
			?>
		</table>
	</div>

	


</div>
