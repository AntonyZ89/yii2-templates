<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$basename = StringHelper::basename($generator->modelClass);
$camel2id = Inflector::camel2id($basename);

echo "<?php\n";
?>

use kartik\export\ExportMenu;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use <?= $generator->indexWidgetType === 'grid' ? "kartik\\grid\\GridView" : "yii\\widgets\\ListView" ?>;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

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
<div class="<?= $camel2id ?>-index box box-primary">
    <div class="box-body no-padding">
<?php if(!empty($generator->searchModelClass)): ?>
<?= "        <?php " . (($generator->indexWidgetType === 'grid' && !$generator->enablePjax) ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>

<?php if ($generator->indexWidgetType === 'grid'): ?>
        <?= "<?= " ?>GridView::widget([
            'dataProvider' => $dataProvider,
            <?= !empty($generator->searchModelClass && !$generator->enablePjax) ? "'filterModel' => \$searchModel,\n" : '' ?>
<?= $generator->enablePjax ? "'pjax' => true,\n" : '' ?>
            'summary' => false,
            'responsive' => false,
            'hover' => true,
            'toolbar' => [
                [
                    'content' => Html::a('<i class="fas fa-redo"></i> ' . Yii::t('app', 'Reset Grid'), [''], [
                        'class' => 'btn btn-default',
                        'title' => Yii::t('app', 'Reset Grid'),
                        <?= $generator->enablePjax ? "'data-pjax' => 0\n" : '' ?>
                    ]),
                ],
                ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                ]),
                '{toggleData}'
            ],
            'panel' => [
                'heading' => false,
                'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> ' . <?= $generator->generateString('Create ' . Inflector::camel2words($basename)) ?>, ['create'], ['class' => 'btn btn-success btn-flat'<?= $generator->enablePjax ? ", 'data-pjax' => 0" : '' ?>]),
                'after' => false,
            ],
            'columns' => ArrayHelper::merge($columns, [
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'width' => '150px',
                    'viewOptions' => [
                        'class' => 'btn btn-sm btn-default',
                    ],
                    'updateOptions' => [
                        'class' => 'btn btn-sm btn-primary'
                    ],
                    'deleteOptions' => [
                        'class' => 'btn btn-sm btn-danger'
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
</div>
