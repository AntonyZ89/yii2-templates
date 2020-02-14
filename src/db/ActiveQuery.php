<?php

namespace antonyz89\templates\db;

use yii\db\ActiveQuery as ActiveQueryBase;
use yii2mod\helpers\ArrayHelper;

/**
 * @property mixed $_alias
 */
class ActiveQuery extends  ActiveQueryBase
{
    public function get_alias()
    {
        return ArrayHelper::last($this->getTableNameAndAlias());
    }
}
