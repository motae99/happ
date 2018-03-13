<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[DrugSupplier]].
 *
 * @see DrugSupplier
 */
class DrugSupplierQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return DrugSupplier[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return DrugSupplier|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
