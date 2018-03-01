<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Insurance]].
 *
 * @see Insurance
 */
class InsuranceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Insurance[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Insurance|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
