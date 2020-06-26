<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\console\widgets\Table;

use app\models\Plot;
use app\models\SearchForm;

use app\services\PlotService;

use yii\helpers\ArrayHelper;


class PlotController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $egrns.
     * @return int Exit code
     */
    public function actionSearch($egrns)
    {
        $egrns = (new SearchForm(['egrns' => $egrns]))->getFormattedEgrns();

        $plots = Yii::createObject(PlotService::class)
            ->getByEgrn($egrns)
            ->query
            ->all();

        $this->stdout(Table::widget($this->getTableConfig($plots)));

        return ExitCode::OK;
    }


    /**
     * Return config for Table widget by plots models.
     * @param $plots
     * @return array
     */
    private function getTableConfig($plots) : array
    {
        $headers = (new Plot)->safeAttributes();

        $rows = ArrayHelper::getColumn($plots, function($plot) {
            $attributes = $plot->attributes;
            unset($attributes['id']);
            return $attributes;
        });

        return ['headers' => $headers, 'rows' => $rows];
    }
}
