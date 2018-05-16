<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;




$this->title = Yii::t('app', 'Register');
$this->params['breadcrumbs'][] = $this->title;

?>
<h1></h1>
<?php $this->registerJs('
	var filterFns = {
	  // show if number is greater than 50
	  numberGreaterThan50: function() {
		var number = $(this).find(".number").text();
		return parseInt( number, 10 ) > 50;
	  },
	  // show if name ends with -ium
	  ium: function() {
		var name = $(this).find(".name").text();
		return name.match( /ium$/ );
	  }
	};	
	
	$(".filters-button-group").on( "click", "button", function() {
	  var filterValue = $( this ).attr("data-filter");
	  // use filterFn if matches value
	  filterValue = filterFns[ filterValue ] || filterValue;
	  $("#w0 .grid").isotope({ filter: filterValue });
	}); 
', $this::POS_END) ?>

<?php /*
    $dataProvider =  new ActiveDataProvider([
	        'query' => \app\models\Appointment::find(),
	    ]);*/
    
    // $filter = ['confirmed', 'booked', 'canceled', 'schadueled', 'processing', 'done'];
?>

<?php  echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="row">

<div class="col-lg-2 eArLangCss">
	<div class="button-group filters-button-group">
	  <button class="button btn-block btn-flat is-checked" data-filter="*">show all</button>
	  <button class="button btn-block btn-flat" data-filter=".canceled">canceled</button>
	  <button class="button btn-block btn-flat" data-filter=".schadueled">schadueled</button>
	  <button class="button btn-block btn-flat" data-filter=".processing">processing</button>
	  <button class="button btn-block btn-flat" data-filter=".done">done</button>
	  <!-- <button class="button btn-block btn-flat" data-filter=".transition">transition</button>
	  <button class="button btn-block btn-flat" data-filter=".alkali, .alkaline-earth">alkali and alkaline-earth</button>
	  <button class="button btn-block btn-flat" data-filter=":not(.transition)">not transition</button>
	  <button class="button btn-block btn-flat" data-filter=".metal:not(.transition)">metal but not transition</button>
	  <button class="button btn-block btn-flat" data-filter="numberGreaterThan50">number &gt; 50</button>
	  <button class="button btn-block btn-flat" data-filter="ium">name ends with –ium</button>
	 -->
	</div>

</div>
<div class="col-lg-10 eArLangCss">
	<?php echo \nerburish\isotopeview\IsotopeView::widget([
		'dataProvider' => $dataProvider,
		'filterAttribute' => 'stat',
		'itemView' => '_item',
		'clientOptions' => [
			'layoutMode' => 'masonry',
		],
		'cssFile' => [
			"@web/css/grid-demo.css"		
		]
	]) ?>

</div>

</div>


