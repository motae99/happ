<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[InvoiceProduct]].
 *
 * @see InvoiceProduct
 */
class InvoiceProductQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return InvoiceProduct[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return InvoiceProduct|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
