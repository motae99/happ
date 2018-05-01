<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Ads]].
 *
 * @see Ambulance
 */
class AdsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Ads[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Ads|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
