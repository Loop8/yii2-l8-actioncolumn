<?php
/**
 * @copyright Copyright (c) 2015 Loop 8 ay
 * @link http://loop8.fi
 * @license http://opensource.org/licenses/MIT
 */

namespace loop8\l8actioncolumn;

use Yii;
use yii\grid\ActionColumn;
use yii\helpers\Html;

/**
 * Extends the YII2 Action Column
 */
class L8ActionColumn extends ActionColumn
{
    /**
     * @var bool Flag to track if the AjaxDeleteAssetBundle has been registered
     */
    protected static $ajaxDeleteAssetRegistered = false;
    
    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();
        
        if (strpos($this->template, '{delete}') !== false) {
            $this->registerAjaxDeleteAsset();
        }
    }
    
    protected function registerAjaxDeleteAsset(): void
    {
        if (self::$ajaxDeleteAssetRegistered) {
            return;
        }
        
        $assetClass = 'app\assets\AjaxDeleteAssetBundle';
        if (class_exists($assetClass)) {
            $assetClass::register(Yii::$app->view);
            self::$ajaxDeleteAssetRegistered = true;
        }
    }

    public static function viewButton(string $url, object $model, $key, bool $visible = true): string
    {
        if (!$visible)
            return '';

        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
            'title' => Yii::t('yii', 'View'),
            'data-pjax' => '0',
        ]);
    }

    public static function updateButton(string $url, object $model, $key, bool $visible = true): string
    {
        if (!$visible)
            return '';

        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
            'title' => Yii::t('yii', 'Update'),
            'data-pjax' => '0',
        ]);
    }

    public static function deleteButton(string $url, object $model, $key, bool $visible = true): string
    {
        if (!$visible)
            return '';

        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
            'title' => Yii::t('yii', 'Delete'),
            'data-pjax' => '0',
        ]);
    }

    public static function ajaxDeleteButton(string $url, object $model, $key, bool $visible = true, array $additionalOptions = []): string
    {
        if (!$visible)
            return '';

        self::registerAjaxDeleteAssetStatic();
        
        $options = [
            'title' => Yii::t('yii', 'Delete'),
            'data-url' => $url,
            'class' => 'l8ajax-delete',
        ];

        if (!empty($additionalOptions)) {
            $options = array_merge($options, $additionalOptions);
        }

        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', $options);
    }
    
    protected static function registerAjaxDeleteAssetStatic(): void
    {
        if (self::$ajaxDeleteAssetRegistered) {
            return;
        }
        
        $assetClass = 'app\assets\AjaxDeleteAssetBundle';
        if (class_exists($assetClass)) {
            $assetClass::register(Yii::$app->view);
            self::$ajaxDeleteAssetRegistered = true;
        }
    }

    public static function ajaxApproveButton(string $url, object $model, $key, bool $visible = true, array $additionalOptions = []): string
    {
        if (!$visible)
            return '';
        $options = [
            'title' => Yii::t('yii', 'Approve'),
            'data-url' => $url,
            'class' => 'l8ajax-approve',
        ];

        if (!empty($additionalOptions)) {
            $options = array_merge($options, $additionalOptions);
        }

        return Html::a('<span class="glyphicon glyphicon-thumbs-up"></span>', '#', $options);
    }

    public static function ajaxRevokeApprovalButton(string $url, object $model, $key, bool $visible = true, array $additionalOptions = []): string
    {
        if (!$visible)
            return '';
        $options = [
            'title' => Yii::t('yii', 'Revoke approval'),
            'data-url' => $url,
            'class' => 'l8ajax-revoke-approval',
        ];

        if (!empty($additionalOptions)) {
            $options = array_merge($options, $additionalOptions);
        }

        return Html::a('<span class="glyphicon glyphicon-thumbs-down"></span>', '#', $options);
    }
}
