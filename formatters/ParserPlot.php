<?php

namespace  app\formatters;

use yii\helpers\ArrayHelper;
use yii\httpclient\ParserInterface;
use yii\httpclient\Response;

class ParserPlot implements ParserInterface
{
    public function parse(Response $response)
    {
        $response = json_decode($response->content, true);

        if (!$this->isValidResponse($response)) {
            return [];
        }

        $parsedData = [];
        foreach ($response as $index => $data) {
            foreach ($this->getParseMap() as $attribute => $needle) {
                $parsedData[$index][$attribute] = ArrayHelper::getValue($data, $needle);
            }
        }

        return $parsedData;
    }


    /**
     * @param $response
     * @return bool whether response is valid.
     */
    private function isValidResponse($response) : bool
    {
        return is_array($response);
    }


    /**
     * @return string[] map to parse response values.
     */
    private function getParseMap()
    {
        return [
            'egrn' => 'number',
            'address' => 'data.attrs.address',
            'price' => 'data.attrs.cad_cost',
            'area' => 'data.attrs.area_value'
        ];
    }
}