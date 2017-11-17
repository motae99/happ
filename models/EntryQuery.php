<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Entry]].
 *
 * @see Entry
 */
class EntryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Entry[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Entry|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
