<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SystemAccount]].
 *
 * @see SystemAccount
 */
class SystemAccountQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SystemAccount[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SystemAccount|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
