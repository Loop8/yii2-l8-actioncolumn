<?php
/**
 * @copyright Copyright (c) 2015 Loop 8 ay
 * @link http://loop8.fi
 * @license http://opensource.org/licenses/MIT
 */

namespace loop8\l8actioncolumn;

use Yii;
//use Closure;
use yii\helpers\Html;
//use yii\helpers\Url;

/**
 * Extends the YII2 Action Column
 */
class L8ActionColumn extends \yii\grid\ActionColumn
{
    /**
     * Return the default view button
     */
    public static function viewButton($url, $model, $key, $visible = true)
    {
        if (!$visible)
            return '';

        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
            'title' => Yii::t('yii', 'View'),
            'data-pjax' => '0',
        ]);
    }

    /**
     * Return the default update button
     */
    public static function updateButton($url, $model, $key, $visible = true)
    {
        if (!$visible)
            return '';

        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
            'title' => Yii::t('yii', 'Update'),
            'data-pjax' => '0',
        ]);
    }

    /**
     * Return the default delete button
     */
    public static function deleteButton($url, $model, $key, $visible = true)
    {
        if (!$visible)
            return '';

        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
            'title' => Yii::t('yii', 'Delete'),
            'data-pjax' => '0',
        ]);
    }

    /**
     * Return the default delete button for ajax
     */
    public static function ajaxDeleteButton($url, $model, $key, $visible = true, $additionalOptions = [])
    {
        if (!$visible)
            return '';

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
}
