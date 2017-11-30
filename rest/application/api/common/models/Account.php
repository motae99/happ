<?php

namespace api\common\models;
use api\common\models\Task;


class Account extends \yii\base\Model
{


	public function calculate($id, $user_salary){
		$arrayName = array();
		$points = 0;
		$b = 1;
		$s = 1;
		$l = 0;
		$month = date("m");
		$actual_salary = $user_salary ;
		$tasks = Task::find()
					->where(['assigned_to' => $id])
					->andWhere(['status' => 'done'])
					// ->andWhere("DATEPART(mm, due_date) = $month" )
					->all();
        foreach ($tasks as $task) {
        	$submission = strtotime($task->submitted_at);
        	$due = strtotime($task->due_date);
        	$hours = round(($due - $submission)/(60*60));
        	if($due > $submission){
        		if($hours >= 5){
        			$b += 5;
        		}else{
        			$b += $hours;
        		}

        	}else{
        		$s -= $hours;
        	}
        	$points += 1;
        
        	// $t[$task->id] = $arrayName;
        }

		$loans = Loan::find()
					->where(['created_by' => $id])
					->andWhere(['status' => 'granted'])
					->all();

		foreach ($loans as $loan) {
			$l += $loan->amount;
		}

		
		$avg = round($b / ($s / 100),2);

		$salary = $actual_salary + $b - $s - $l;

		$arrayName['monthly_avg'] = $avg;
		$arrayName['bonus'] = $b-1;
		$arrayName['loans'] = $l;
        $arrayName['Production_account'] = $points;
		$arrayName['penality'] = $s-1;
		$arrayName['salary'] = $salary;

        return $arrayName;
    }

    public function report($id){
    	$done = Task::find()
					->where(['assigned_to' => $id])
					->andWhere(['status' => 'done'])
					// ->andWhere("DATEPART(mm, due_date) = $month" )
					->count();

		$total = Task::find()
					->where(['assigned_to' => $id])
					->count();
		if($total > 0){
			$tasks = round($done / ($total / 100),2);
		}else{
			$tasks = 0;
		}

		$reports = array();
		$reports['tasks progress'] = $tasks;
		$reports['monthly tasks'] = $total;
		return $reports ;
    }

}

