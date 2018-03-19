<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "physician".
 *
 * @property int $id
 * @property string $name
 * @property int $contact_no
 * @property string $email
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property Availability[] $availabilities
 * @property Qualification[] $qualifications
 */
class Physician extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'physician';
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
            [['name', 'contact_no', 'regestration_no'], 'required'],
            [['contact_no', 'created_by', 'updated_by', 'regestration_no'], 'integer'],
            [['email'], 'string'],
            [['created_at', 'updated_at', 'specialization_id', 'extra_info', 'university', 'photo'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['contact_no'], 'unique'],
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
            'contact_no' => Yii::t('app', 'Contact No'),
            'email' => Yii::t('app', 'Email'),
            'regestration_no' => Yii::t('app', 'regestration_no'),
            'specialization_id' => Yii::t('app', 'specialization_id'),
            'university' => Yii::t('app', 'university'),
            'extra_info' => Yii::t('app', 'extra_info'),
            'photo' => Yii::t('app', 'photo'),
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
        return $this->hasMany(Availability::className(), ['physician_id' => 'id']);
    }

    public function getSpec()
    {
        return $this->hasMany(Specialization::className(), ['physician_id' => 'id']);
    }

    public function getCal()
    {
        return $this->hasMany(Calender::className(), ['physician_id' => 'id']);
    }

    public function getAppo()
    {
        return $this->hasMany(Appointment::className(), ['physician_id' => 'id']);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQualifications()
    {
        return $this->hasMany(Qualification::className(), ['physician_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PhysicianQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PhysicianQuery(get_called_class());
    }
}
