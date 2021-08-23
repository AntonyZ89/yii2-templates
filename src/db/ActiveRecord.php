<?php


namespace antonyz89\templates\db;

use Throwable;
use Yii;
use yii\base\UnknownPropertyException;
use yii\db\ActiveRecord as ActiveRecordBase;
use yii\helpers\Inflector;

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
                $variable = $this->findVariable($name);

                return $this->$variable !== null ? $this->{'list' . ucfirst($name)}()[$this->$variable] : null;
            }

            if (strpos($name, '.') !== false) {
                return object_get($this, $name);
            }

            if (str_ends_with($name, 'AsCurrency')) {
                $name = str_replace('AsCurrency', '', $name);
                $variable = $this->findVariable($name);

                return Yii::$app->formatter->asCurrency($this->$variable ?? 0);
            }

            throw new UnknownPropertyException($e->getMessage(), $e->getCode(), $e);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function findVariable(string $variable)
    {
        if ($this->hasAttribute($variable)) {
            return $variable;
        } else {
            return Inflector::camel2id($variable, '_', true);
        }
    }
}
