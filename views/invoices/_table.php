<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

use app\models\SystemAccount;
use app\models\OutStanding;


use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Stock;
use app\models\Client;
use kartik\select2\Select2;
use yii\web\JsExpression;
use wbraganca\dynamicform\DynamicFormWidget;

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


<div class="invoices-form">
	<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
		  <div class="box box-info box-solid">
			<div class="box-header">

			</div>
			<div class="box-body" style="min-height: 908px; max-height: auto;  box-shadow: 0 0 30px black; padding: 0 15px 0 15px;">
				<div class="col-sm-8" style="min-height: 400px; border-right: 2px solid #ecf0f5;">
					<h1 style="text-align: center; margin: 30px; font-size: 69px; font-family: e; font-weight: bold;">
					Invoice
					</h1>
					<span class="text-bold"> #<?= $model->id?></span>
					<span class="pull-right text-bold"> <?= $model->created_at?></span>
					<hr style="margin-top: 0px; margin-bottom: 0px; border-top: 4px solid #e4b83c" >
				</div>
				<div class="col-sm-4" style="min-height: 400px; padding-left: 0; padding-right: 0;">
					<div class="col-sm-12" style="min-height: 180px;">
						Inventory Details

					</div>
					<div class="col-sm-12" style="min-height: 180px; border-top:2px solid #ecf0f5">
						<?= $form->field($model, 'client_id')
							->dropDownList(ArrayHelper::map(Client::find()->all(), 'id', 'client_name'),
							[
							'prompt'=>'Client Name',
							// 'onchange'=> 'pro($(this))'

							])->label(false);  
						?>
					</div>
				</div>
				<?php DynamicFormWidget::begin([
				'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
				'widgetBody' => '.container-items', // required: css class selector
				'widgetItem' => '.item', // required: css class
				'limit' => 10, // the maximum times, an element can be added (default 999)
				// 'min' => 0, // 0 or 1 (default 1)
				'insertButton' => '.add-item', // css class
				'deleteButton' => '.remove-item', // css class
				'model' => $modelsItem[0],
				'formId' => 'dynamic-form',
				'formFields' => [
				'product_id',
				'quantity',
				],
				]); ?>

				<div style="margin:70px"></div>

				<table class="table table-responsive">
					<tr>
						<th class="text-center" style=" background-color: #00c0ef; width: 2%; color: white;"></th>
						<th class="text-left" style=" background-color: #00c0ef; width: 40%; color: white;">Item</th>
						<th class="text-center" style=" background-color: #00c0ef; width: 10%; color: white;">Quantity</th>
						<th class="text-center" style=" background-color: #00c0ef; width: 10%; color: white;">Price</th>
						<th class="text-center" style=" background-color: #00c0ef; width: 10%; color: white;">Tax</th>
						<th class="text-right" style=" background-color: #00c0ef; width: 20%; color: white;">LineTotal</th>
					</tr>
				
					<tr>
						<td class="text-center" style="width: 2%">fasdf</td>
						<td class="text-left" style="width: 40%">adfaf</td>
						<td class="text-center" style="width: 10%">fad</td>
						<td class="text-center" style="width: 10%">asdfa</td>
						<td class="text-center" style="width: 10%">asdfaf</td>
						<td class="text-right" style="width: 20%">asdfas</td>
					</tr>
				</table>

	
	

			</div>
		</div>
	  </div>
	</div>

</div>
