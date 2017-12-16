
<?php 
        
    $totalPaid = 0;
    $tinvoicesreturned = 0;
    $tinvoicesremaining =0;
    $tinvoicespr = 0;
    $tinvoicespaid = 0;
    $totalProduct = 0 ;
    $rpayment = 0;
    $invoicesReturnedPayment = 0;
    $totalReturned = 0 ;
    if ($invoices) {
?>


<table style="padding-top:60px;">
    <tr >
        <th>#NO</th>
        <th><?= Yii::t('invo', 'Date')?></th>
        <th>تاريخ</th>
        <th></th>
        <th> T R Pyamet</th>
        <th>T Returned</th>
        <th>Total</th>
        <th>Paid</th>
        <th>Remainig</th>
    </tr>
<?php 
foreach ($invoices as $invoice) {
    $products = $invoice->invoiceProducts;
    $returned = $invoice->invoiceReturnedProducts;
    $payments = $invoice->payments;
    $returnedPayment = $invoice->returnedPayment;
?>

    <tr class="<?= $model->color_class?>">
        <td><?=$invoice->id;?></td>
        <td><?=$invoice->date;?></td>
        <td></td>
        <th></th>
        <th></th>
        <th></th>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr >
        <th></th>
        <th class="invopro">Item</th>
        <th class="invopro">Quantity</th>
        <th class="invopro">UnitCost</th>
        <th class="invopro">Discount</th>
        <th class="invopro">LineTotal</th>
    </tr>
    <?php 
        $totalProduct = 0 ;
        foreach ($products as $p) {
        
    ?>
    <tr>
        <td></td>
        <td><?=$p->product->product_name;?></td>
        <td><?=$p->quantity;?></td>
        <td><?=$p->selling_rate;?></td>
        <td><?=$p->discount;?></td>
        <?php $lineTotal = $p->quantity * $p->selling_rate - $p->discount;?>
        <td><?= $lineTotal?></td>
        <?php $totalProduct += $lineTotal ;?>
    </tr>
    <?php
        }
    ?>

    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Total</td>
        <td class="<?= $model->color_class?>"><?= $totalProduct ?></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>

    <?php if($returned){?>
    <tr >
        <th></th>
        <th class="invopror">ReturnedItem</th>
        <th class="invopror">Quantity</th>
        <th class="invopror">UnitCost</th>
        <th class="invopror">Discount</th>
        <th class="invopror">LineTotal</th>
    </tr>
    <?php  
        $totalReturned = 0 ;
        foreach ($returned as $r) {

    ?>
    <tr>
        <td></td>
        <td><?=$r->product->product_name;?></td>
        <td><?=$r->quantity;?></td>
        <td><?=$r->selling_rate;?></td>
        <td><?=$r->discount;?></td>
        <?php $lineTotal = $r->quantity * $r->selling_rate - $r->discount;?>
        <td><?= $lineTotal?></td>
        <?php $totalReturned += $lineTotal ;?>
    </tr>
    <?php
        }
    ?>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="bg-red"><?= $totalReturned?></td>
    </tr>

    <?php 
        }
    ?>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <th></th>
        <th class="invopay">Date</th>
        <th class="invopay">Method</th>
        <th class="invopay">Amount</th>
    </tr>
    <?php 
            $totalPaid = 0;
        foreach ($payments as $pa) {
    ?>
    <tr>
        <td></td>
        <td><?=$pa->created_at;?></td>
        <td><?=$pa->mode;?></td>
        <?php $amount = $pa->amount ;?>
        <td><?=$amount;?></td>
        <?php $totalPaid += $amount ;?>
    </tr>
    <?php
        }
    ?>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>Paid</td>
        <td></td>
        <td></td>
        <td></td>
        <td class="<?= $model->color_class?>"><?= $totalPaid ;?></td>

        
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <?php $rpayment = 0;
        if ($returnedPayment) { ?>

    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <?php $rpayment = $returnedPayment->amount ;?>
        <th class="bg-purple"><?= $rpayment?></th>
    </tr>
    <?php } ?>
    <tr>
        <td>*</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr >
        <td class="<?= $model->color_class?>"><?=$invoice->id;?></td>
        <td class="<?= $model->color_class?>"><?=$invoice->date;?></td>
        <td class="<?= $model->color_class?>"></td>
        <td class="<?= $model->color_class?>"></td>
        <td class="bg-purple"><?= $rpayment ?> </td>
        <td class="bg-red"> <?= $totalReturned ?></td>
        <td class="<?= $model->color_class?>"><?=$invoice->amount;?></td>
        <td class="<?= $model->color_class?>"><?= $totalPaid ;?></td>
        <?php $re = $totalProduct - $totalPaid ;?>
        <td class="<?= $model->color_class?>"><?= $re?></td>
    </tr>
     <tr>
        <td>#</td>
        <td></td>
        <td></td>
        <td></td>
        <td><?= $invoicesReturnedPayment += $rpayment ;?></td>
        <td> <?= $tinvoicesreturned += $totalReturned;?></td>
        <td><?= $tinvoicespr += $totalProduct;?></td>
        <td><?= $tinvoicespaid += $totalPaid;?></td>
        <td><?= $tinvoicesremaining += $re;?></td>
    </tr>
<?php
    }
?>
</table>

<table class="table-bordered table table-responsive">
<tr>
    <td>Remainig</td>
    <td><?= $tinvoicesremaining ?></td>
</tr>
<tr>
    <td>T R Pyamet</td>
    <td><?= $invoicesReturnedPayment ?></td>
</tr>
<tr>
    <td>Balance</td>
    <td><?= $tinvoicesremaining - $invoicesReturnedPayment ?></td>
</tr>
</table>
<?php
    }
?>
