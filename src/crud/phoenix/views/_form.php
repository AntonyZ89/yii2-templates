<?php

use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator antonyz89\templates\crud\Generator */

/* @var $model ActiveRecord */

$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use antonyz89\mdb\helpers\Html;
use antonyz89\mdb\widgets\form\Form;
use antonyz89\mdb\widgets\form\ActiveForm;
use yii\web\View;
use <?= ltrim($generator->modelClass, '\\') . ";\n" ?>

/* @var $this View */
/* @var $model <?= array_slice(explode('\\', $generator->modelClass), -1)[0] ?> */
/* @var $form ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
    <?= "<?php " ?>$form = ActiveForm::begin() ?>
    <?= "<?php " ?>Form::begin(['model' => $model]) ?>
    <?= "<?php " ?>Html::beginRow() ?>
    
    <?php foreach ($generator->getColumnNames() as $i => $attribute) {
        if (in_array($attribute, $safeAttributes)) {
            echo ($i === 1 ? '' : "\t\t") . "<?= Html::col(" . $generator->generateActiveField($attribute) . ") ?>\n\n";
        }
    } ?>

    <?= "<?php " ?>Html::endRow() ?>
    <?= "<?php " ?>Form::end() ?>
    <?= "<?php " ?>ActiveForm::end() ?>
</div>