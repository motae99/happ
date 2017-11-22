<?php 
namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class MyComponent extends Component
{
  public function MyFunction($param1,$param2){
    return $param1+$param2; // (:)
  }
}