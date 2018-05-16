<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior; 


class Role extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }


    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'required'],
            [['item_name', 'user_id'], 'string'],
            [['created_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item_name' => Yii::t('app', 'item_name'),
            'user_id' => Yii::t('app', 'user_id'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }


    /**
     * {@inheritdoc}
     * @return StockQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new StockQuery(get_called_class());
    // }
}
