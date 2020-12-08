yii2-templates
============

<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YATHVT293SXDL&source=url">
  <img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" alt="Donate with PayPal" />
</a>

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist antonyz89/yii2-templates dev-master
```

or add

```
"antonyz89/yii2-templates": "dev-master"
```

to the require section of your `composer.json` file.

Usage
-----
**environments/dev/common/config/main**

and run ``php init`` again
```php
if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['bootstrap'] = ['gii'];
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'model' => [
                'class' => 'antonyz89\templates\crud\Generator',
                'templates' => [
                    'default' => '@antonyz89/templates/model/default', // add default template
                ]
            ],
            'crud' => [
                'class' => 'antonyz89\templates\crud\Generator',
                'templates' => [
                    'admin-lte' => '@antonyz89/templates/crud/admin-lte', // add admin-lte template
                    'default' => '@antonyz89/templates/crud/default', // add default template
                ]
            ]
        ],
    ];
}
```

Easy Pjax with `_search.php`
------

**Kartik GridView ONLY**

CRUD generated by Gii with any template already do it, just add `YiiTemplateAsset` to complete

**Usage:**

1 - Just add `YiiTemplateAsset` on `YOUR_MODULE/assets/AppAsset`

```php
use antonyz89\templates\assets\YiiTemplatesAsset;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [];
    public $depends = [
        YiiTemplatesAsset::class // ADD
    ];
}
```

2 - Now, just enable `pjax` on GridView

```php
GridView::widget([
    'dataProvider' => $dataProvider,
    'pjax' => true, // here
    'columns' => [
        'id',
        'name',
        [
            'class' => 'kartik\grid\ActionColumn',
            'width' => '150px',
            'buttonOptions' => [
                'class' => 'btn btn-sm btn-default'
            ],
            'updateOptions' => [
                'class' => 'btn btn-sm btn-primary'
            ],
            'deleteOptions' => [
                'class' => 'btn btn-sm btn-danger'
            ]
        ]
    ]
]);
```

3 - Add `data-ajax => true` on _search's form

```php
<div class="example-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => true // HERE
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-1">
            <?= $form->field($model, 'id') ?>
        </div>
        <div class="col-md-5">
            <?= $form->field($model, 'name') ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
```
DONE!

Just type on _search's fields and GridView will reload

## Pjax only from form's submit

To use Pjax only from form's submit, just add `'pjax-only-on-submit' => true` on **ActiveForm::begin** from  `_search.php`

```php
<?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => true,
            'pjax-only-on-submit' => true // HERE
        ],
    ]); ?>

```

## ActiveQuery

### Alias

Use `@alias.` on query to replace it with `::tableName` or `alias`.

```php
// Query
User::find()->alias('example')->where(['@alias.name' => 'Antony'])->groupBy('@alias.age');
```
```SQL
# result
SELECT `user`.* FROM `user` as `example` WHERE `example`.`name` = 'Antony' GROUP BY `example`.`age`
```

### Disable GROUP BY

set `$query->groupBy(false)` to disable any `GROUP BY` on query
