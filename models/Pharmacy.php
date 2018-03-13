<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior; 


/**
 * This is the model class for table "pharmacy".
 *
 * @property int $id
 * @property string $name
 * @property string $state
 * @property string $city
 * @property string $address
 * @property string $working_days
 * @property string $from_hour
 * @property int $to_hour
 * @property string $app_service
 * @property string $logitude
 * @property string $latitude
 * @property int $phone
 * @property int $rate
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property Invoice[] $invoices
 * @property Stock[] $stocks
 */
class Pharmacy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pharmacy';
    }


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

    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'state', 'city', 'address', 'working_days', 'from_hour', 'to_hour', 'app_service', 'logitude', 'latitude', 'phone', 'rate', ], 'required'],
            [['address', 'app_service', 'logitude', 'latitude', 'owner_name'], 'string'],
            [['from_hour', 'created_at', 'working_days', 'updated_at', 'owner_name', 'secodary_phone', 'website'], 'safe'],
            [[ 'phone', 'rate', 'created_by', 'updated_by'], 'integer'],
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
            'app_service' => Yii::t('app', 'App Service'),
            'logitude' => Yii::t('app', 'Logitude'),
            'latitude' => Yii::t('app', 'Latitude'),
            'phone' => Yii::t('app', 'Phone'),
            'rate' => Yii::t('app', 'Rate'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['pharmacy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasMany(Stock::className(), ['phar_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PharmacyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PharmacyQuery(get_called_class());
    }
}
