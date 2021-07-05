<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator antonyz89\templates\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use common\assets\material\Html;
use common\assets\material\ActiveForm;
use yii\web\View;
use <?= ltrim($generator->modelClass, '\\').";\n" ?>

/* @var $this View */
/* @var $model <?= array_slice(explode('\\', $generator->modelClass), -1)[0] ?> */
/* @var $form ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form mdl-cell mdl-cell--12-col">
    <div class="mdl-card mdl-shadow--2dp">
        <div class="mdl-card__supporting-text">

    <?= "<?php " ?>$form = ActiveForm::begin(); ?>
        <div class="mdl-grid">
<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo "\t\t\t\t<?= Html::cell(" . $generator->generateActiveField($attribute) . ", 'mdl-cell--4-col mdl-cell--2-col-phone') ?>\n\n";
    }
} ?>
        </div>
        <div class="mdl-grid">
            <?= "<?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('Save') ?> : <?= $generator->generateString('Update') ?>, ['class' => 'm-auto ' . Html::BUTTON_COLORS[$model->isNewRecord ? 'green' : 'teal']]) ?>
        </div>
    <?= "<?php " ?>ActiveForm::end(); ?>
        </div>
    </div>
</div>
