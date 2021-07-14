<?php


namespace antonyz89\templates\db;

use yii\base\UnknownPropertyException;
use yii\db\ActiveRecord as ActiveRecordBase;

/**
 * Class ActiveRecord
 * @package antonyz89\templates\db
 *
 */
class ActiveRecord extends ActiveRecordBase
{
    /**
     * @inheritDoc
     * @throws UnknownPropertyException
     */
    public function __get($name)
    {
        try {
            return parent::__get($name);
        } catch (UnknownPropertyException $e) {
            if (str_ends_with($name, 'AsText')) {
                $name = str_replace('AsText', '', $name);

                return $this->$name !== null ? $this->{'list' . ucfirst($name)}()[$this->$name] : null;
            }

            if (str_ends_with($name, 'AsCurrency')) {
                $name = str_replace('AsCurrency', '', $name);

                return \Yii::$app->formatter->asCurrency($this->$name ?? 0);
            }

            throw new UnknownPropertyException($e->getMessage(), $e->getCode(), $e);
        }
    }
}

