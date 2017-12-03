<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $payment app\models\Payments */
/* @var $form yii\widgets\ActiveForm */
?>
<?php 

    $payments = $model->payments;
    $total_paid = 0;
    if($payments){
        foreach ($payments as $p) {
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
<div class="promix-form">

    <?php $form = ActiveForm::begin(
        [   
            'id' => 'promise-form',
            'options'=>['method' => 'post'],
            'action' => Url::to(['invoices/promise', 'id' => $model->id]),
            
        ]);

    ?>



        <?= $form->field($outstanding, "due_date")
	    	->widget(DatePicker::classname(), 
        		[
                    'type' => DatePicker::TYPE_INPUT,
                    'options' => ['placeholder' => 'Due Date'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                	]    
                ])
            ->label(false);
        ?>
    	<?= $form->field($outstanding, 'amount')
	        ->textInput(
	            [
	                'type' => 'number', 
	                'max' => $creditMax, 
	                'min' => 1,
	                'placeholder'=>'Cash Amount',
	            ])
	        ->label(false);
    	?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>