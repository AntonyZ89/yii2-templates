yii2-templates
============

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
**environments/dev/YOUR_MODULE/config**

example : **environments/dev/backend/config**
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
                'class' => 'yii\gii\generators\model\Generator',
                'templates' => [
                    'default' => '@vendor/antonyz89/yii2-templates/src/model/default', // add default template
                ]
            ],
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'admin-lte' => '@vendor/antonyz89/yii2-templates/src/crud/admin-lte', // add admin-lte template
                    'default' => '@vendor/antonyz89/yii2-templates/src/crud/default', // add default template
                ]
            ]
        ],
    ];
}
```

run ``php init`` again
