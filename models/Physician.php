<?php

namespace app\models;

use Yii;

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
    public function rules()
    {
        return [
            [['name', 'contact_no'], 'required'],
            [['contact_no', 'created_by', 'updated_by'], 'integer'],
            [['email'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
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
