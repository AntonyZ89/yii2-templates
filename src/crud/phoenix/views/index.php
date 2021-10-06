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

use antonyz89\mdb\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "common\\widgets\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?php // $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>
use common\widgets\grid\ActionColumn;
use yii\helpers\ArrayHelper;
use common\helpers\FieldHelper;


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
<?= "<?php //" ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>
<div class="<?= $camel2id ?>-index">
<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        'filterSelector' => '#<?= strtolower($basename) ?>search-search',
        <?php if ($generator->enablePjax): ?>
'pjax' => true,
        'pjaxSettings' => [
            'options' => [ // kartik' GridView's pjax options
                'options' => [ // Yii2 Pjax's options
                    'data-target' => '<?= $camel2id ?>-search-drawer'
                ]
            ]
        ],
        <?php endif; ?>
        'toolbar' => [
            [
                'content' => Html::tag('div', [
                    Html::tag('span', Html::icon('search'), 'input-group-text'),
                    Html::activeTextInput(
                        $searchModel,
                        'search',
                        ArrayHelper::merge(
                            ['class' => 'form-control border-start-0'],
                            FieldHelper::addon(FieldHelper::DIRECTION_APPEND, Html::icon('lock'))
                        )
                    )
                ] , 'input-group input-group-sm')
            ],
            [
                'content' => Html::a(
                    Html::icon('redo'),
                    [''],
                    [
                        'class' => 'btn btn-floating btn-sm shadow-0',
                        'data-mdb-toggle' => 'tooltip',
                        'title' => Yii::t('app', 'Reset Grid'),
                        'data-pjax' => 0
                    ]
                ),
            ],
            [
                'content' => Html::a(
                    Html::icon('plus'),
                    ['create'],
                    [
                        'class' => 'btn btn-floating btn-success btn-sm shadow-0',
                        'data-pjax' => 0,
                    ]
                )
            ]
        ],
        'panel' => [
            'before' => "<h5>$this->title</h5>",
        ],
        'columns' => ArrayHelper::merge($columns, [
            [
                'class' => ActionColumn::class,
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
