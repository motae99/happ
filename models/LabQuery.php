<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Lab]].
 *
 * @see Lab
 */
class LabQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Lab[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Lab|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
