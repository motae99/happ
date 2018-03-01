<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clinic".
 *
 * @property int $id
 * @property string $name
 * @property string $state
 * @property string $city
 * @property string $address
 * @property int $primary_contact
 * @property int $secondary_contact
 * @property string $longitude
 * @property string $latitude
 * @property string $is_clinic
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property Availability[] $availabilities
 * @property Specialization[] $specializations
 */
class Clinic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clinic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'state', 'city', 'address', 'primary_contact', 'type', 'working_days'], 'required'],
            [['address', 'longitude', 'latitude', 'type'], 'string'],
            [['primary_contact', 'secondary_contact', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'start', 'end'], 'safe'],
            [['name', 'state', 'city'], 'string', 'max' => 45],
            [['primary_contact'], 'unique'],
            [['secondary_contact'], 'unique'],
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
            'primary_contact' => Yii::t('app', 'Primary Contact'),
            'secondary_contact' => Yii::t('app', 'Secondary Contact'),
            'longitude' => Yii::t('app', 'Longitude'),
            'latitude' => Yii::t('app', 'Latitude'),
            'type' => Yii::t('app', 'Type'),
            'working_days' => Yii::t('app', 'Working Days'),
            'start' => Yii::t('app', 'start time'),
            'end' => Yii::t('app', 'end time'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAvailabilities()
    {
        return $this->hasMany(Availability::className(), ['clinic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecializations()
    {
        return $this->hasMany(Specialization::className(), ['clinic_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ClinicQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClinicQuery(get_called_class());
    }
}
