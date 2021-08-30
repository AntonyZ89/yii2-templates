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

use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "kartik\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

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
    <?= "<?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>
<div class="<?= $camel2id ?>-index">
<?php if ($generator->indexWidgetType === 'grid'): ?>
        <?= "<?= " ?>GridView::widget([
            'dataProvider' => $dataProvider,
            <?php if ($generator->enablePjax): ?>
                'pjax' => true,
                'pjaxSettings' => [ // kartik' GridView's pjax options
                    'options' => [ // Yii2 Pjax's options
                        'data-target' => '<?= $camel2id ?>-search-drawer'
                    ]
                ]
            <?php endif; ?>
            'drawer' => '<?= $camel2id ?>-search-drawer',
            'summary' => false,
            'responsive' => true,
            'hover' => true,
            'toolbar' => [
                [
                    'content' => Html::a(Html::icon('redo') . ' ' . Yii::t('kvgrid', 'Reset Grid'), [''], [
                        'class' => 'btn btn-light',
                        'title' => Yii::t('app', 'Reset Grid'),
                        <?= $generator->enablePjax ? "'data-pjax' => 0\n" : '' ?>
                    ]),
                ],
                ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $columns,
                    'showConfirmAlert' => false
                ])
            ],
            'panel' => [
                'before' => Html::a(Html::icon('plus') . ' ' . <?= $generator->generateString('Create ' . Inflector::camel2words($basename)) ?>, ['create'], ['class' => 'btn btn-success'<?= $generator->enablePjax ? ", 'data-pjax' => 0" : '' ?>]),
            ],
            'columns' => ArrayHelper::merge($columns, [
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'width' => '120px',
                    'visibleButtons' => [
                        'view' => false
                    ]
                ]
            ])
        ]); ?>
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
