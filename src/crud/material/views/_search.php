<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator antonyz89\templates\crud\Generator */

$camel2id = Inflector::camel2id(StringHelper::basename($generator->modelClass));

echo "<?php\n";
?>

use common\assets\material\Html;
use common\assets\material\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form ActiveForm */
?>

<div class="<?= $camel2id ?>-search mdl-layout__drawer drawer-right" id="<?= $camel2id ?>-search-drawer" tabindex="-1">
    <div class="scroll__wrapper">
        <div class="scroller">
            <div class="scroll__container mdl-card__supporting-text">
                <?= "<?php " ?>$form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
<?php if ($generator->enablePjax): ?>
                    'options' => [
                        'data-pjax' => true
                    ],
<?php endif; ?>
                ]); ?>
                <div class="mdl-grid">
<?php
$count = 0;
foreach ($generator->getColumnNames() as $attribute) {
    echo "\t\t\t\t\t<?= Html::cell(" . $generator->generateActiveSearchField($attribute) . ") ?>\n\n";
}
?>
                </div>

<?php if(!$generator->enablePjax): ?>
                <div class="form-group">
                    <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Search') ?>, ['class' => 'btn btn-primary']) ?>
                    <?= "<?= " ?>Html::a(<?= $generator->generateString('Reset') ?>, ['index'], ['class' => 'btn btn-default']) ?>
                </div>
<?php endif; ?>

                <?= "<?php " ?>ActiveForm::end(); ?>
            </div>
        </div>
        <div class='scroller__bar'></div>
    </div>
</div>