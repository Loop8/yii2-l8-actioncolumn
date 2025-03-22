<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Ajax Delete functionality
 * 
 * Provides a Bootstrap modal confirmation dialog for delete operations
 * and handles the AJAX request with proper CSRF token handling.
 */
class AjaxDeleteAssetBundle extends AssetBundle
{
    public $sourcePath = '@vendor/loop8/yii2-l8-actioncolumn/assets';
    
    public $js = [
        'ajax-delete.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset', // Required for Bootstrap modal
    ];
} 