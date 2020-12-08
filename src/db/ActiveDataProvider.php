<?php


namespace antonyz89\templates\db;

use yii\base\InvalidConfigException;
use \yii\data\ActiveDataProvider  as BaseActiveDataProvider;
use yii\db\QueryInterface;

class ActiveDataProvider extends BaseActiveDataProvider
{
    /**
     * {@inheritdoc}
     * @throws InvalidConfigException
     */
    protected function prepareTotalCount()
    {
        if (!$this->query instanceof QueryInterface) {
            throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
        }
        $query = clone $this->query;

        return (int) $query->limit(-1)->offset(-1)->orderBy([])->groupBy(false)->count('*', $this->db);
    }
}
