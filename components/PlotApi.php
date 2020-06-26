<?php

namespace app\components;

use Yii;
use app\formatters\ParserPlot;
use app\models\EgrnApiSearchInterface;
use yii\base\Component;
use yii\httpclient\Client;

class PlotApi extends Component implements EgrnApiSearchInterface
{
    public $baseUrl = 'http://pkk.bigland.ru/api/test/';

    private $_httpClient;

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        if (!($this->_httpClient instanceof Client)) {
            $this->_httpClient = Yii::createObject([
                'class' => Client::class,
                'baseUrl' => $this->baseUrl,
                'parsers' => [
                    Client::FORMAT_JSON => ParserPlot::class
                ]
            ]);
        }

        return $this->_httpClient;
    }


    /**
     * Get plots data by egrns.
     * @param $egrns
     * @return array
     */
    public function findByEgrn(array $egrns) : array
    {
        $response = $this->getHttpClient()
            ->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setMethod('GET')
            ->setUrl('plots')
            ->setData($this->prepareEgrnData($egrns))
            ->send();

        return $response->isOk ? $response->data : [];
    }


    /**
     * @param array $egrns
     * @return array
     */
    private function prepareEgrnData(array $egrns) : array
    {
        return [
            'collection' => [
                'plots' => $egrns
            ]
        ];
    }
}