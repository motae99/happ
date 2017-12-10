<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%account_type}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 *
 * @property SystemAccount[] $systemAccounts
 */
class AccountType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['name'], 'string', 'max' => 45],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystemAccounts()
    {
        return $this->hasMany(SystemAccount::className(), ['account_type_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return AccountTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AccountTypeQuery(get_called_class());
    }
}
