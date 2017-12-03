<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

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
<div class="cash-form">

    <?php $form = ActiveForm::begin(
        [   
            'id' => 'cash-form',
            'options'=>['method' => 'post'],
            'action' => Url::to(['invoices/cash', 'id' => $model->id]),
            
        ]); 
    ?>

    <?= $form->field($payment, 'amount')
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