<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Drugs]].
 *
 * @see Drugs
 */
class DrugsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Drugs[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Drugs|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
