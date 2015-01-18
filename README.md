Extended ActionColumn for YII2 GridView
=======================================
Adds functions to get default button markup

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist loop8/yii2-l8-actioncolumn "*"
```

or add

```
"loop8/yii2-l8-actioncolumn": "*"
```

to the require section of your `composer.json` file.

Usage
-----

This extension adds the following static functions to the ActionColumn:

- L8ActionColumn::viewButton($url, $model, $key, $visible = true)
- L8ActionColumn::updateButton($url, $model, $key, $visible = true)
- L8ActionColumn::deleteButton($url, $model, $key, $visible = true)
- L8ActionColumn::ajaxDeleteButton($url, $model, $key, $visible = true, $options = [])

These functions can be used to render or hide the default `ActionColumn` buttons depending on the `visible` flag. This saved you from having to rewrite the default button markup in every `GridView` widget.
The `L8ActionColumn::ajaxDeleteButton` function adds an `options` array which can be used to pass data to the ajax call and the button will have a CSS class name `l8ajax-delete` which you can use for event binding.

Once the extension is installed, simply use it in your code by:

```
<?php
use loop8\l8actioncolumn\L8ActionColumn;
?>
```

and using it in your view files with GridView:

```
<?php \yii\widgets\Pjax::begin(['timeout' => 5000, 'id' => 'pjax-container']); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // column definitions

            [
                'class' => L8ActionColumn::className(),
                //'template' => '{view} {update} {delete}', // you can leave out the buttons which you won't need
                'buttons' => [
                    'view' => function($url, $model, $key) {
                        return L8ActionColumn::viewButton($url, $model, $key, !empty(Yii::$app->user->identity)); // check that the user is authenticated
                    },
                    'update' => function($url, $model, $key) {
                        return L8ActionColumn::updateButton($url, $model, $key, !empty(Yii::$app->user->identity)); // check that the user is authenticated
                    },
                    'delete' => function($url, $model, $key) {
                        return L8ActionColumn::ajaxDeleteButton($url, $model, $key, !empty(Yii::$app->user->identity), ['data-name' => yii\helpers\Html\Html::encode($model['firstName'] . " " . $model['lastName'])]); // check that the user is authenticated
                    }
                ]
            ],
        ],
    ]); ?>

<?php \yii\widgets\Pjax::end(); ?>

<?php
$initScript = <<<EOF
\$(document).on('click', '.l8ajax-delete', function (event) {
    if(confirm('Are you sure you want to delete "' + \$(event.currentTarget).attr('data-name') + '"?')) {
        \$.ajax(\$(event.currentTarget).attr('data-url'), {
            dataType: "json",
            type: "post"
        }).done(function(data) {
            if(data.response = 'Ok') {
                \$.pjax.reload({container:'#pjax-container'});
            } else {
                alert('Error : ' + data.response);
            }
        });
    }
});
EOF;

$this->registerJs($initScript);

```
