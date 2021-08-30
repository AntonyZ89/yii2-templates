<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator antonyz89\templates\crud\Generator */

echo "<?php\n";
?>

use antonyz89\mdb\helpers\Html;
use antonyz89\mdb\widgets\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form ActiveForm */
?>

<nav id="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search-drawer" class="collapse h-100 d-lg-block sidebar sidebar-right bg-white">
    <div class="position-sticky">
        <?= "<?php " ?>$form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        <?php if ($generator->enablePjax) : ?>
            'options' => [
            'data-pjax' => true
            ],
        <?php endif; ?>
        ]); ?>

        <?= "<?php " ?>Html::beginRow('m-0') ?>
        
        <?php
        foreach ($generator->getColumnNames() as $attribute) {
            echo "    <?= Html::col(" . $generator->generateActiveSearchField($attribute) . ") ?>\n\n";
        }
        ?>

        <?= "<?php " ?>Html::endRow() ?>

        <?php if (!$generator->enablePjax) : ?>
            <div class="form-group flex-end">
                <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Search') ?>, ['class' => 'btn-primary']) ?>
                <?= "<?= " ?>Html::a(<?= $generator->generateString('Reset') ?>, ['index'], ['class' => 'btn-default']) ?>
            </div>
            
        <?php endif; ?>
        <?= "<?php " ?>ActiveForm::end(); ?>
    </div>
</nav>