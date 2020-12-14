<?php


namespace antonyz89\templates\model;

use ReflectionClass;
use yii\gii\generators\model\Generator as BaseGenerator;

class Generator extends BaseGenerator
{
    /**
     * {@inheritDoc}
     */
    public function formView()
    {
        $class = new ReflectionClass(BaseGenerator::class);

        return dirname($class->getFileName()) . '/form.php';
    }

}
