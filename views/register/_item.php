<!-- <div style="border: 1px solid blue">
	<span class="queue">33</span>
	<h5 class="name"><?= $model->id ?></h5>
	<p class="symbol"><?= $model->stat ?></p>
	<p class="number"><?= $model->fee ?></p>
	<p class="weight"><?= $model->status ?></p>
</div> -->


<span class="queue">3</span>
<p>
	<span>
		<?php 
			if ($model->patient->gender == 'male') {?>
			<span class="fa fa-2x fa-male"></span>	
		<?php	}elseif ($model->patient->gender == 'female'){?>
			<span class="fa fa-2x fa-female"></span>	

		<?php	}else{?>
			<span class="fa fa-2x fa-transgender"></span>	

		<?php	}
		?>
	</span> 
	<span><?=$model->patient->name ?> / </span>
	<span><?=$model->age?> Y</span>
</p>
<p>
	<?php
	if ($model->insured == 'yes') {
		echo $model->fee.' / '.$model->insured_fee;
	}else{
		echo $model->fee;
	}
	?>
</p>
<p></p>
<p></p>
<p></p>





