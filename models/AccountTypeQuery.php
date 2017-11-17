<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AccountType]].
 *
 * @see AccountType
 */
class AccountTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AccountType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AccountType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
