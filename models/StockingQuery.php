<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Stocking]].
 *
 * @see Stocking
 */
class StockingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Stocking[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Stocking|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
