<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AmbulanceRequest]].
 *
 * @see AmbulanceRequest
 */
class AmbulanceRequestQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AmbulanceRequest[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AmbulanceRequest|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
