<?php

namespace antonyz89\templates\db;

use yii\db\ActiveQuery as ActiveQueryBase;
use yii\db\Expression;
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

    /**
     * @return static
     */
    public function rand()
    {
        return $this->orderBy(new Expression('RAND()'));
    }

    /**
     * {@inheritDoc}
     */
    public function onCondition($condition, $params = [])
    {
        $_condition = [];

        foreach ($condition as $column => $value) {
            $column = str_replace('@alias', $this->_alias, $column);
            $_condition[$column] = $value;
        }

        return parent::onCondition($_condition, $params);
    }

    // TODO auto alias for others queries

}
