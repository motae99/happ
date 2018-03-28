<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lab".
 *
 * @property int $id
 * @property string $name
 * @property string $state
 * @property string $city
 * @property string $address
 * @property string $working_days
 * @property string $from_hour
 * @property int $to_hour
 * @property string $logitude
 * @property string $latitude
 * @property int $phone
 * @property int $secondary_phone
 * @property int $rate
 * @property string $photo
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 */
class Lab extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lab';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'state', 'city', 'address', 'working_days', 'from_hour', 'to_hour', 'logitude', 'latitude', 'phone', 'rate', 'created_at', 'created_by'], 'required'],
            [['address', 'working_days', 'logitude', 'latitude', 'photo'], 'string'],
            [['from_hour', 'created_at', 'updated_at'], 'safe'],
            [['to_hour', 'phone', 'secondary_phone', 'rate', 'created_by', 'updated_by'], 'integer'],
            [['name', 'state', 'city'], 'string', 'max' => 45],
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
            'state' => Yii::t('app', 'State'),
            'city' => Yii::t('app', 'City'),
            'address' => Yii::t('app', 'Address'),
            'working_days' => Yii::t('app', 'Working Days'),
            'from_hour' => Yii::t('app', 'From Hour'),
            'to_hour' => Yii::t('app', 'To Hour'),
            'logitude' => Yii::t('app', 'Logitude'),
            'latitude' => Yii::t('app', 'Latitude'),
            'phone' => Yii::t('app', 'Phone'),
            'secondary_phone' => Yii::t('app', 'Secondary Phone'),
            'rate' => Yii::t('app', 'Rate'),
            'photo' => Yii::t('app', 'Photo'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return LabQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LabQuery(get_called_class());
    }
}
