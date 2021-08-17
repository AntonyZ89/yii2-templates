<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator antonyz89\templates\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$basename = StringHelper::basename($generator->modelClass);
$camel2id = Inflector::camel2id($basename);

echo "<?php\n";
?>

use kartik\export\ExportMenu;
use common\assets\material\Html;
use common\assets\material\ActionColumn;
use yii\helpers\ArrayHelper;
use <?= $generator->indexWidgetType === 'grid' ? "common\\assets\\material\\GridView" : "yii\\widgets\\ListView" ?>;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider antonyz89\templates\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words($basename))) ?>;
$this->params['breadcrumbs'][] = $this->title;

$columns = [
<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "\t" . (++$count < 6 ? '' : '//') . "'$name',\n";
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        echo "\t". (++$count < 6 ? '' : '//'). "'$column->name" . ($format === 'text' ? "" : ":" . $format) . "',\n";
    }
}
?>
];

?>
<?php if(!empty($generator->searchModelClass)): ?>
<?= "<?php " . (($generator->indexWidgetType === 'grid' && !$generator->enablePjax) ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>
<div class="<?= $camel2id ?>-index mdl-cell mdl-cell--12-col">
    <div class="mdl-card mdl-shadow--2dp">
<?php if ($generator->indexWidgetType === 'grid'): ?>
        <?= "<?= " ?>GridView::widget([
            'dataProvider' => $dataProvider,
            <?= !empty($generator->searchModelClass && !$generator->enablePjax) ? "'filterModel' => \$searchModel,\n" : '' ?>
<?= $generator->enablePjax ? "'pjax' => true,\n" : '' ?>
<?= $generator->enablePjax ? "\t\t\t'pjaxSettings' => [
                'options' => [ // kartik' GridView's pjax options
                    'options' => [ // Yii2 Pjax's options
                        'data-target' => '$camel2id-search-drawer'
                    ]
                ]
            ],\n" : '' ?>
            'drawer' => '<?= $camel2id ?>-search-drawer',
            'summary' => false,
            'responsive' => true,
            'hover' => true,
            'toolbar' => [
                [
                    'content' => Html::a(Html::icon('restart_alt') . ' ' . Yii::t('kvgrid', 'Reset Grid'), [''], [
                        'class' => Html::BUTTON_CLASS . ' ' . Html::BUTTON_COLORS['white'],
                        'title' => Yii::t('kvgrid', 'Reset Grid'),
                        'data-pjax' => 0
                    ]),
                ],
                ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $columns,
                    'showConfirmAlert' => false
                ])
            ],
            'panel' => [
                'before' => Html::a(Html::icon('add') . ' ' . <?= $generator->generateString('Create ' . Inflector::camel2words($basename)) ?>, ['create'], ['class' => Html::BUTTON_CLASS . ' ' . Html::BUTTON_COLORS['green']<?= $generator->enablePjax ? ", 'data-pjax' => 0" : '' ?>]),
            ],
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => ArrayHelper::merge($columns, [
                [
                    'class' => ActionColumn::class
                ]
            ])
        ]) ?>
    <?php else: ?>
        <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
        return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
        ]) ?>
    <?php endif; ?>
    </div>
</div>
