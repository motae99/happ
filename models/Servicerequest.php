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
class Servicerequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servicerequest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'name', 'phone', 'address'], 'required'],
            [['service_id', 'phone'], 'integer'],
            [['address', 'description', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'service_id' => Yii::t('app', 'service_id'),
            'name' => Yii::t('app', 'name'),
            'phone' => Yii::t('app', 'phone'),
            'address' => Yii::t('app', 'address'),
            'description' => Yii::t('app', 'description'),
            'status' => Yii::t('app', 'status'),
            'created_at' => Yii::t('app', 'created_at'),
            'created_by' => Yii::t('app', 'created_by'),
            'updated_at' => Yii::t('app', 'updated_at'),
            'updated_by' => Yii::t('app', 'updated_by'),
        
        ];
    }

    public function getSer()
    {
        return $this->hasOne(Services::className(), ['id' => 'service_id']);
    }

    /**
     * {@inheritdoc}
     * @return ServicerequestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ServicerequestQuery(get_called_class());
    }
}
