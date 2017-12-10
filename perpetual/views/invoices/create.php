<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Product;

use yii\web\JsExpression;
use wbraganca\dynamicform\DynamicFormWidget;
?>

<div class="invoices-form">


    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    
    <div class="row">
        <div class="col-sm-4">
			<?= $form->field($model, 'client_id')->textInput() ?>
        </div> 

        <div  class="col-sm-4"></div>

        <div id="info" class="col-sm-4" >
            <div id="class" class="small-box ">
                <div class="inner">
                  <h4 class="name"></h4>
                  <p class="address"></p>
                  <p class="phone"></p>
                </div>
                <div class="icon">
                  <i class="fa fa-support"></i>
                </div>
                <a class="small-box-footer" href="#">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
          </div>

        </div>
    </div>


    
        <div class="row">
        <div class="panel panel-default">
        <div class="panel-heading"><h4><i class="fa fa-cart-plus"> </i>  Purchase </h4></div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 10, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsItem[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'product_id',
            		'quantity',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelsItem as $i => $modelItem): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Add</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelItem->isNewRecord) {
                                echo Html::activeHiddenInput($modelItem, "[{$i}]id");
                            }
                        ?>
                        <div class="row">
                            <div class="col-sm-3">
                                <?= $form->field($modelItem, "[{$i}]product_id")->dropDownList(ArrayHelper::map(Product::find()->all(), 'id', 'product_name'),
                                    ['prompt'=>'---Select AN Item ---']); 
                                ?>
                            </div>
                            <div id="q" class="col-sm-2">
                                <?= $form->field($modelItem, "[{$i}]quantity")->textInput(['maxlength' => 128]) ?>
                            </div>
                            <div id="r" class="col-sm-2">
                                <?= $form->field($modelItem, "[{$i}]quantity")->textInput(['maxlength' => 128]) ?>
                            </div>
                            <div class="col-sm-3">
                                <?php echo $form->field($modelItem, "[{$i}]quantity")->textInput() ?>
                      
                            </div>
                            <div id="total" class="col-sm-2">
                            
                            </div>

                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
        </div>
    </div>

        <div class="raw">
            <div class="col-sm-6"></div>
            <div class="col-sm-6"></div>
        </div>
        <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-6">
            <?= Html::resetButton('<i class="glyphicon glyphicon-minus-sign"> Reset</i>', ['class' => 'reset btn bg-orange btn-flat btn-block']) ?>
        </div>
        <div class="col-sm-6">
            <?= Html::submitButton( '<i class="glyphicon glyphicon-plus-sign"> Purchase Items</i>', ['class' =>  'btn bg-purple btn-flat btn-block']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?> 

</div>