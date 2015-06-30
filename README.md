Yii2 mediaelement
=================
A complete HTML/CSS audio/video player built on top MediaElement.js and jQuery. For Yii2.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist maksyutin/yii2-mediaelement "*"
```

or add

```
"maksyutin/yii2-mediaelement": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= maksyutin\mediaelement\AutoloadWidget::widget([
        'mediafile' => BaseYii::getAlias('@web').'/video/emailcap.mp4',
        'width' => 849,
        'height' => 478,
        'title' => 'Title',
        'modal' => true,
        'playerOptions' => [
            'defaultVideoWidth' => 480,
            'defaultVideoHeight' => 270,
            'keyActions' => '[]',
            'enableKeyboard' => true,
        ]
    ]);
    ?>
```
