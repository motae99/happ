<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Availability]].
 *
 * @see Availability
 */
class AvailabilityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Availability[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Availability|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
