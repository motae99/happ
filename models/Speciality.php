<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "Speciality".
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
class Speciality extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'speciality';
    }

    // public function behaviors()
    // {
    //      return [
    //          // [
    //          //     'class' => SluggableBehavior::className(),
    //          //     'attribute' => 'message',
    //          //     'immutable' => true,
    //          //     'ensureUnique'=>true,
    //          // ],
    //          [
    //              'class' => BlameableBehavior::className(),
    //              'createdByAttribute' => 'created_by',
    //              'updatedByAttribute' => 'updated_by',
    //          ],
    //          'timestamp' => [
    //              'class' => 'yii\behaviors\TimestampBehavior',
    //              'attributes' => [
    //                  ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
    //                  ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
    //              ],
    //              'value' => date('Y-m-d H:i:s'),
    //          ],
    //      ];
    // }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    /**
     * {@inheritdoc}
     * @return SpecialityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SpecialityQuery(get_called_class());
    }
}
