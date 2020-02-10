<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;
use <?= ltrim($generator->modelClass, '\\').";\n" ?>

/* @var $this yii\web\View */
/* @var $model <?= array_slice(explode('\\', $generator->modelClass), -1)[0] ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view panel panel-default">
    <div class="panel-heading">
        <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>

        <?= "<?= " ?>Html::a(<?= $generator->generateString('Update') ?>, ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary']) ?>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Delete') ?>, ['delete', <?= $urlParams ?>], [
        'class' => 'btn btn-danger',
        'data' => [
        'confirm' => <?= $generator->generateString('Are you sure you want to delete this item?') ?>,
        'method' => 'post',
        ],
        ]) ?>
    </div>
    <div class="panel-body">
        <?= "<?= " ?>DetailView::widget([
            'model' => $model,
            'attributes' => [
<?php
    if (($tableSchema = $generator->getTableSchema()) === false) {
        foreach ($generator->getColumnNames() as $i => $name) {
            echo "\t\t\t\t'" . $name . "',\n";
        }
    } else {
        foreach ($generator->getTableSchema()->columns as $i => $column) {
            $format = $generator->generateColumnFormat($column);
            echo "\t\t\t\t'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
    ?>
            ],
        ]) ?>
    </div>
</div>
