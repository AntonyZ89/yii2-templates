<?php


namespace antonyz89\templates\model;

use antonyz89\templates\db\ActiveRecord;
use ReflectionClass;
use yii\gii\generators\model\Generator as GeneratorBase;

class Generator extends GeneratorBase
{
    public $baseClass = ActiveRecord::class;

    /**
     * {@inheritDoc}
     */
    public function formView()
    {
        $class = new ReflectionClass(GeneratorBase::class);

        return dirname($class->getFileName()) . '/form.php';
    }

}
