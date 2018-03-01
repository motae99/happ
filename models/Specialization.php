<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "specialization".
 *
 * @property int $id
 * @property int $clinic_id
 * @property string $specialty
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property Clinic $clinic
 */
class Specialization extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'specialization';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clinic_id', 'specialty', 'created_at', 'created_by'], 'required'],
            [['clinic_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['specialty'], 'string', 'max' => 45],
            [['clinic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clinic::className(), 'targetAttribute' => ['clinic_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'clinic_id' => Yii::t('app', 'Clinic ID'),
            'specialty' => Yii::t('app', 'Specialty'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClinic()
    {
        return $this->hasOne(Clinic::className(), ['id' => 'clinic_id']);
    }

    /**
     * {@inheritdoc}
     * @return SpecializationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SpecializationQuery(get_called_class());
    }
}
