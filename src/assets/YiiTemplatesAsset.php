<?php

namespace antonyz89\templates\assets;

use yii\web\AssetBundle;

/**
 * This asset bundle provides the base JavaScript files for the Yii2 Templates.
 *
 * @author AntonyZ89
 * @link https://github.com/AntonyZ89/yii2-templates
 */
class YiiTemplatesAsset extends AssetBundle
{
    public $sourcePath = '@antonyz89/templates/scripts';
    public $js = [
        'pjax.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
