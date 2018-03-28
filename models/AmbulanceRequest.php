<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ambulance_request".
 *
 * @property int $id
 * @property int $ambulance_id
 * @property string $from_location
 * @property string $to_location
 * @property string $phone_no
 * @property int $requested_by
 * @property string $requested_at
 * @property string $status
 */
class AmbulanceRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ambulance_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ambulance_id', 'from_location', 'to_location', 'phone_no', 'requested_by', 'requested_at', 'status'], 'required'],
            [['ambulance_id', 'requested_by'], 'integer'],
            [['from_location', 'to_location', 'phone_no', 'status'], 'string'],
            [['requested_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ambulance_id' => Yii::t('app', 'Ambulance ID'),
            'from_location' => Yii::t('app', 'From Location'),
            'to_location' => Yii::t('app', 'To Location'),
            'phone_no' => Yii::t('app', 'Phone No'),
            'requested_by' => Yii::t('app', 'Requested By'),
            'requested_at' => Yii::t('app', 'Requested At'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AmbulanceRequestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AmbulanceRequestQuery(get_called_class());
    }
}
