<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Physician]].
 *
 * @see Physician
 */
class PhysicianQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Physician[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Physician|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
