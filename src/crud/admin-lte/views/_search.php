<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator antonyz89\templates\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search">

    <?= "<?php " ?>$form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
<?php if ($generator->enablePjax): ?>
        'options' => [
            'data-pjax' => true
        ],
<?php endif; ?>
    ]); ?>

<?php
$count = 0;
foreach ($generator->getColumnNames() as $attribute) {
    echo "    <?= " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
}
?>
<?php if(!$generator->enablePjax): ?>
    <div class="form-group">
        <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Search') ?>, ['class' => 'btn btn-primary']) ?>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Reset') ?>, ['index'], ['class' => 'btn btn-default']) ?>
    </div>

<?php endif; ?>
    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
