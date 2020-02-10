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
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view box box-primary">
    <div class="box-header">
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Atualizar') ?>, ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Excluir') ?>, ['delete', <?= $urlParams ?>], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => <?= $generator->generateString('Tem certeza que deseja excluir este item?') ?>,
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="box-body no-padding">
        <?= "<?= " ?>DetailView::widget([
            'model' => $model,
            'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "\t\t\t\t'" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        $format = stripos($column->name, 'created_at') !== false || stripos($column->name, 'updated_at') !== false ? 'datetime' : $generator->generateColumnFormat($column);
        echo "\t\t\t\t'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
    }
}
?>
            ],
        ]) ?>
    </div>
</div>
