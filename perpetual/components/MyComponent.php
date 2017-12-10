<?php 
namespace app\components;

use Yii;
use yii\base\Component;

use app\models\SystemAccount;
use app\models\Entry;
use app\models\Dollar;

use yii\base\InvalidConfigException;

class MyComponent extends Component
{	
	
	public function Rate(){
		$rate = Dollar::find()->orderBy(['created_at' => SORT_DESC])->one();
        return $rate->value;
	}
  
	public function Increase($account, $amount, $transaction_id){		
		$entry = new Entry();
        $entry->transaction_id = $transaction_id; 
        $entry->account_id = $account->id;
        if($account->to_increase == 'debit') {
        	$entry->is_depit = 'yes'; 
        }else{
        	$entry->is_depit = 'no'; 
        }
        $entry->amount = $amount; 
        $entry->description = "Increase"; 
        $entry->date = date('Y-m-d'); 
        $entry->balance = $account->balance + $amount; 
        if($entry->save(false)){
            $account->balance += $amount;
            $account->save(false); 
        }
        return true;
	}
	public function Decrease($account, $amount, $transaction_id){		
		$entry = new Entry();
        $entry->transaction_id = $transaction_id; 
        $entry->account_id = $account->id;
        if($account->to_increase == 'debit') {
        	$entry->is_depit = 'no'; 
        }else{
        	$entry->is_depit = 'yes'; 
        }
        $entry->amount = $amount; 
        $entry->description = "Decrease"; 
        $entry->date = date('Y-m-d'); 
        $entry->balance = $account->balance - $amount; 
        if($entry->save(false)){
            $account->balance -= $amount;
            $account->save(false); 
        }
        return true;
	}
}