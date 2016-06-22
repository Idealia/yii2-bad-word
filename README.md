Bad word filter for Yii2
========================
Bad word filter for Yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist idealia/yii2-bad-word "*"
```

or add

```
"idealia/yii2-bad-word": "*"
```

to the require section of your `composer.json` file.

Apply migrations

```
php yii migrate --migrationPath=@vendor/idealia/yii2-bad-word/migrations
```

Add to config file
```
'components' => [
        'badword' => [
            'class' => \idealia\badword\BadWord::class,
            // 'obfuscation' => true,
            'provider' => [
                'class' => \idealia\badword\BadWordDbProvider::class
            ]
        ],
]
```

Usage
-----

```
$foo = Yii::$app->badword->filter('your text with bad words to replace by ***');
```

In active record validator
```
public function rules()
{
   return [
        ['title',  BadWordFilter::class],
   ]
}
```