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
        return parent::onCondition($this->putAlias($condition), $params);
    }

    /**
     * {@inheritDoc}
     */
    public function andFilterWhere(array $params)
    {
        return parent::andFilterWhere($this->putAlias($params));
    }

    /**
     * {@inheritDoc}
     */
    public function where($condition, $params = []) {
        return parent::where($this->putAlias($condition), $params);
    }

    /**
     * {@inheritDoc}
     */
    public function andWhere($condition, $params = []) {
        return parent::andWhere($this->putAlias($condition), $params);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhere($condition, $params = []) {
        return parent::orWhere($this->putAlias($condition), $params);
    }

    /**
     * {@inheritDoc}
     */
    public function filterWhere(array $condition) {
        return parent::filterWhere($this->putAlias($condition));
    }

    /**
     * {@inheritDoc}
     */
    public function orFilterWhere(array $condition) {
        return parent::orFilterWhere($this->putAlias($condition));
    }

    /**
     * @param array $params
     * @return array
     */
    protected function putAlias($params) {
        $_params = [];

        foreach ($params as $column => $value) {
            $column = str_replace('@alias', $this->_alias, $column);
            $value = str_replace('@alias', $this->_alias, $value);
            $_params[$column] = $value;
        }

        return $_params;
    }
}
