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
     * Return the default view button
     * @param $url
     * @param $model
     * @param $key
     * @param bool $visible
     * @return string
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
     * @param $url
     * @param $model
     * @param $key
     * @param bool $visible
     * @return string
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
     * @param $url
     * @param $model
     * @param $key
     * @param bool $visible
     * @return string
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
     * @param $url
     * @param $model
     * @param $key
     * @param bool $visible
     * @param array $additionalOptions
     * @return string
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

    /**
     * Return the default approve button for ajax
     * @param $url
     * @param $model
     * @param $key
     * @param bool $visible
     * @param array $additionalOptions
     * @return string
     */
    public static function ajaxApproveButton($url, $model, $key, $visible = true, $additionalOptions = [])
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

    /**
     * Return the default revoke approval button for ajax
     * @param $url
     * @param $model
     * @param $key
     * @param bool $visible
     * @param array $additionalOptions
     * @return string
     */
    public static function ajaxRevokeApprovalButton($url, $model, $key, $visible = true, $additionalOptions = [])
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
