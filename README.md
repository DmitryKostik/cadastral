# cadastral
Test project which get info about plot by cadastral link

## Installation
- Min php version 7.0.
- Clone project into your `PROJECT_PATH`
- Configure your apache or nginx server to `PROJECT_PATH`/web
- Run `composer install`
- Run `php yii migrate`

## Actions
Search by web interface: [Web](/site/search).

Search by api: [API](plot-api/search). Required param egrn: egrn's separated by comma.

Search by console: `php yii plot/search {comma_separated_egrns}`.

## Plot Service

Configure DI container by default, or add your own dependencies.
```php
[
    'app\models\EgrnApiSearchInterface' => 'app\components\PlotApi',
    'app\models\EgrnSearchInterface' => 'app\models\Plot'
];
```

Then you can create service by `Yii::createObject(PlotService::class)`

Properties
- EgrnSearchInterface $plotRepository
- EgrnApiSearchInterface $plotApiRepository

You can configure the properties.

Methods:
- getByEgrn(array $egrns). Found All plots by egrns using DB and API.

API

![Api](https://github.com/DmitryKostik/cadastral/blob/master/blob/Cadast%20API.png?raw=true)

Web

![Web](https://github.com/DmitryKostik/cadastral/blob/master/blob/Cadastr%20Web.png?raw=true)

CMD

![Command line](https://github.com/DmitryKostik/cadastral/blob/master/blob/Cadastr%20Console.png?raw=true)




