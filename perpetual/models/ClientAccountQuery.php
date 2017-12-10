<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ClientAccount]].
 *
 * @see ClientAccount
 */
class ClientAccountQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ClientAccount[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ClientAccount|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
