<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
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

<div>
  <h1></h1>
</div>

<?php 
$AEurl = Url::to(["availability", "id" => $model->id]);
$UEurl = Url::to(["modify"]);

$JSEvent = <<<EOF
    function(start, end) {
        var start = moment(start).locale("en").format("h:mm a");
        var end = moment(end).locale("en").format("h:mm a");
        $.ajax({
           url: "{$AEurl}",
           data: { start : start, end : end },
           type: "GET",
           success: function(data) {
               $('#modal').modal('show');
               //$('#modalHeader').html('<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>Make a Reservation</h3>');
               $("#modalContent").addClass("row");
               $('#modalContent').html(data);
               $('#availability-from_time').attr('value',start);
               $('#availability-to_time').attr('value',end);
           }
        });
            }
EOF;

$JSEventClick = <<<EOF
    function(calEvent, jsEvent, view) {
        var eventId = calEvent.id;
        $.ajax({
           url: "{$UEurl}",
           data: { id : eventId },
           type: "GET",
           success: function(data) {
               $('#modal').modal('show');
               // $('#modalHeader').html('<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>تعزير مواعيد الحجز</h3>');
               $('#modalContent').addClass("row");
               $('#modalContent').html(data);
               $('#modal').modal();

           }
        });
        $(this).css('border-color', 'red');
    }
EOF;

// $JsF = <<<EOF
//         function (event, element) {
//             var start_time = moment(event.start).format("DD-MM-YYYY, h:mm:ss a");
//                 var end_time = moment(event.end).format("DD-MM-YYYY, h:mm:ss a");

//             element.popover({
//                     title: event.title,
//                     placement: 'top',
//                     html: true,
//                 global_close: true,
//                 container: 'body',
//                 trigger: 'hover',
//                 delay: {"show": 500},
//                     content: "<table class='table'><tr><th>Customer Name : </th><td>" + event.description + " </td></tr><tr><th> Phone No : </th><td>" + event.title + "</td></tr><tr><th> Start Time : </t><td>" + start_time + "</td></tr><tr><th> End Time : </th><td>" + end_time + "</td></tr><tr><th> Status : </th><td>" + event.event_type + "</td></tr></table>"
//                 });
//                }
// EOF;

?>

<div class="box box-solid box-info">
	<?php Pjax::begin(['id'=>'timeTable']); ?>
         <?= \yii2fullcalendar\yii2fullcalendar::widget([        
          'clientOptions' => [
              // 'minTime'=> "05:00:00",
              // 'maxTime'=> "23:59:59",
              'defaultView' => 'agendaWeek',
              // 'fixedWeekCount' => false,
              'weekNumbers'=>true,
              'editable' => true,
              'selectable' => true,
              // 'eventLimit' => true,
              // 'eventLimitText' => '+ Lectures',
              'selectHelper' => true,
              'header' => [
                  'right' => 'month,agendaWeek,agendaDay',
                  'center' => 'title',
                  'left' => 'today prev,next'
              ],
              'select' =>  new \yii\web\JsExpression($JSEvent),
              'eventClick' => new \yii\web\JsExpression($JSEventClick),
              // 'eventRender' => new \yii\web\JsExpression($JsF),
              'aspectRatio' => 2,
              'timeFormat' => 'hh(:mm) A'
          ],
          'events' => Url::toRoute(['table', 'id'=>$model->id])
        ]); ?> 
    <?php Pjax::end();  ?>
</div>
<div>
<?php  echo $this->render('table', ['model' => $model]) ?>
</div>