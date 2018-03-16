<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use app\models\Clinic;
use yii\helpers\ArrayHelper;
use kartik\time\TimePicker;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Physician */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Physicians'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="physician-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('<i class="fa fa-plus"></i>', ['value' => Url::to(['physician/availability', 'id'=>$model->id]), 'title' => Yii::t('app', 'Add'), 'class' => 'btn btn-flat bg-blue showModalButton']); ?>

        
    </p>

   

</div>
<div>
<?php  //echo $this->render('avail', ['model' => $model, 'available' => $available]) ?>
</div>