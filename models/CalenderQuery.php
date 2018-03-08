<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Clinic]].
 *
 * @see Clinic
 */
class CalenderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Clinic[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Clinic|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
