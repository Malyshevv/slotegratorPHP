<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $css = [
        'css/main.css',
    ];
    public $js = [
    	'https://cdn.jsdelivr.net/npm/places.js@1.16.4',
        'js/main.js',
    ];
}
