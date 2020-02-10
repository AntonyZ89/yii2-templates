<?php

use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\web\View;
use <?= ltrim($generator->modelClass, '\\').";\n" ?>

/* @var $this View */
/* @var $model <?= array_slice(explode('\\', $generator->modelClass), -1)[0] ?> */
/* @var $form ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form panel panel-default">
    <div class="panel-heading">
        <h2 class="no-margin"><?= '<?= ' ?>Html::encode($this->title) ?></h2>
    </div>
    <div class="panel-body">
        <?= "<?php " ?>$form = ActiveForm::begin(); ?>

        <?php foreach ($generator->getColumnNames() as $i => $attribute) {
            if (in_array($attribute, $safeAttributes)) {
                echo ($i === 1 ? '' : "\t\t") . "<?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
            }
        } ?>
        <div class="form-group">
            <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Save') ?>, ['class' => 'btn btn-success']) ?>
        </div>

        <?= "<?php " ?>ActiveForm::end(); ?>
    </div>
</div>
