<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior; 


/**
 * This is the model class for table "stock".
 *
 * @property int $id
 * @property int $phar_id
 * @property int $sup_id
 * @property int $drug_id
 * @property int $quantity
 * @property string $created_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $updated_at
 * @property string $buying_price
 * @property string $selling_price
 *
 * @property Drugs $drug
 * @property Pharmacy $phar
 * @property DrugSupplier $sup
 */
class Stock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stock';
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
            [['phar_id', 'sup_id', 'drug_id', 'quantity', 'buying_price', 'selling_price'], 'required'],
            [['phar_id', 'sup_id', 'drug_id', 'quantity', 'created_by', 'updated_by', 'updated_at'], 'integer'],
            [['created_at'], 'safe'],
            [['buying_price', 'selling_price'], 'number'],
            [['drug_id'], 'exist', 'skipOnError' => true, 'targetClass' => Drugs::className(), 'targetAttribute' => ['drug_id' => 'id']],
            [['phar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pharmacy::className(), 'targetAttribute' => ['phar_id' => 'id']],
            [['sup_id'], 'exist', 'skipOnError' => true, 'targetClass' => DrugSupplier::className(), 'targetAttribute' => ['sup_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'phar_id' => Yii::t('app', 'Phar ID'),
            'sup_id' => Yii::t('app', 'Sup ID'),
            'drug_id' => Yii::t('app', 'Drug ID'),
            'quantity' => Yii::t('app', 'Quantity'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'buying_price' => Yii::t('app', 'Buying Price'),
            'selling_price' => Yii::t('app', 'Selling Price'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrug()
    {
        return $this->hasOne(Drugs::className(), ['id' => 'drug_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhar()
    {
        return $this->hasOne(Pharmacy::className(), ['id' => 'phar_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSup()
    {
        return $this->hasOne(DrugSupplier::className(), ['id' => 'sup_id']);
    }

    /**
     * {@inheritdoc}
     * @return StockQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StockQuery(get_called_class());
    }
}
