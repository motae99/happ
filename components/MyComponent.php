<?php 
namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class MyComponent extends Component
{	
	public function RateSdp($value){
		$rate = $value/20;
		return $rate;
	}

	public function RateUsd($value){
		$rate = $value*20;
		return $rate;
	}

	public function Rate(){
		return 22;
	}
  
  // public function MyFunction($param1,$param2){
  //   return $param1+$param2; // (:)
  // }
}