<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PharInsu]].
 *
 * @see PharInsu
 */
class PharInsuQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PharInsu[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PharInsu|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
