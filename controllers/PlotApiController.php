<?php
namespace app\controllers;

use Yii;

use yii\rest\Controller;

use app\models\SearchForm;

use app\services\PlotService;

class PlotApiController extends Controller
{
    public function actionSearch($egrns)
    {
        $egrns = (new SearchForm(['egrns' => $egrns]))->getFormattedEgrns();

        return Yii::createObject(PlotService::class)->getByEgrn($egrns);
    }
}