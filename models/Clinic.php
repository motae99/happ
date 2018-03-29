<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;

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

    public function behaviors()
    {
         return [
             // [
             //     'class' => SluggableBehavior::className(),
             //     'attribute' => 'message',
             //     'immutable' => true,
             //     'ensureUnique'=>true,
             // ],
             [
                 'class' => BlameableBehavior::className(),
                 'createdByAttribute' => 'created_by',
                 'updatedByAttribute' => 'updated_by',
             ],
             'timestamp' => [
                 'class' => 'yii\behaviors\TimestampBehavior',
                 'attributes' => [
                     ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                     ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                 ],
                 'value' => date('Y-m-d H:i:s'),
             ],
         ];
    }
    
    public function rules()
    {
        return [
            [['name', 'state', 'city', 'address', 'primary_contact', 'photo','type', 'working_days'], 'required'],
            [['address', 'longitude', 'latitude', 'type', 'manager'], 'string'],
            [['primary_contact', 'secondary_contact', 'created_by', 'updated_by', 'fax'], 'integer'],
            [['created_at', 'updated_at', 'start', 'end', 'info', 'email', 'fax', 'color'], 'safe'],
            [['name', 'state', 'city'], 'string', 'max' => 45],
            // [['primary_contact'], 'unique'],
            // [['secondary_contact'], 'unique'],
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
            'manager' => Yii::t('app', 'manager'),
            'working_days' => Yii::t('app', 'Working Days'),
            'start' => Yii::t('app', 'start time'),
            'end' => Yii::t('app', 'end time'),
            'photo' => Yii::t('app', 'photo'),
            'special_services' => Yii::t('app', 'special_services'),
            'app_services' => Yii::t('app', 'app_services'),
            'fax' => Yii::t('app', 'fax'),
            'info' => Yii::t('app', 'info'),
            'email' => Yii::t('app', 'Email'),
            'rate' => Yii::t('app', 'rate'),
            'color' => Yii::t('app', 'color'),
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

    public static function getPhoto($photo)
    {
        $dispImg = is_file(Yii::getAlias('@webroot').'/img/'.$photo) ? true :false;
        return Yii::getAlias('@web')."/img/".(($dispImg) ? $photo : "no-photo.png");
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
