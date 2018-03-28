<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ambulance".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $rate
 * @property string $working_hourse
 */
class Ambulance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ambulance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'working_hourse', 'address'], 'required'],
            [['address', 'rate', 'working_hourse'], 'string'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'address' => Yii::t('app', 'Address'),
            'rate' => Yii::t('app', 'Rate'),
            'working_hourse' => Yii::t('app', 'Working Hourse'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AmbulanceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AmbulanceQuery(get_called_class());
    }
}
