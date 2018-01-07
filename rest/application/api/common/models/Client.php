<?php


namespace api\common\models;

class Client extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{client}}';
	}

	 public function fields()
    {
        return [
            'id',
            'client_name',
            'phone',
            'address',
            // 'recivableBalance' => function($model) { return $model->recivable->balance; },
            // 'recivableAccountNO' => function($model) { return $model->recivable->id; },
            // 'obening' => 
            // 'balance' => Yii::t('app', 'Existing Balance'),
            // 'color_class' => Yii::t('app', 'Color'),
            // 'balance' => Yii::t('app', 'balance'),
            // 'clear' => Yii::t('app', 'Clear'),
        ];
    }
    // public function extraFields() {
    //     return [
    //         'account' => function($model) { return $model->recivable; },
    //         'aa' => function($model) { return $model->recivable; }
    //     ];
    // }

    // public function getRecivable()
    // {
    //     $account = $this->hasOne(SystemAccount::className(), ['id' => 'account_id']);
    //     return $account ; 
    //     // return 1;
    // }

	public static function find() {
		// return new ClientQuery(get_called_class());

		$query = new ClientQuery(get_called_class());

	    // $query->alias('c')
	    //     ->leftJoin(SystemAccount::tableName().' as','sa.id=c.account_id');

	    return $query;
	}
}

class ClientQuery extends \api\components\db\ActiveQuery
{

}