<?php

namespace tests\unit\services;

use Codeception\Test\Unit;
use app\models\Plot;
use app\services\PlotService;
use Yii;

class PlotServiceTest extends Unit
{
    const EGRNS_ARRAY = ['69:27:0000022:1306','69:27:0000022:1307'];
    const NONEXISTENT_EGRN = '11:11:111111:1111';

    /**
     * @var PlotService
     */
    private $service;

    public function testPlotsBeenAddedToDb()
    {
        $this->service = Yii::createObject(PlotService::class);

        $this->service->plotRepository::deleteAll(['egrn' => static::EGRNS_ARRAY]);

        $this->service->getByEgrn(static::EGRNS_ARRAY);

        $added = $this->service->plotRepository::findByEgrnColumn(static::EGRNS_ARRAY);
        $this->assertTrue(count($added) == count(static::EGRNS_ARRAY));
    }


    public function testPlotsNotAddedToDbIfExist()
    {
        $this->service = Yii::createObject(PlotService::class);

        $this->service->plotRepository::deleteAll(['egrn' => static::EGRNS_ARRAY]);

        $this->service->getByEgrn(static::EGRNS_ARRAY);
        $this->service->getByEgrn(static::EGRNS_ARRAY);

        $added = $this->service->plotRepository::findByEgrnColumn(static::EGRNS_ARRAY);

        $this->assertTrue(count($added) == count(static::EGRNS_ARRAY));
    }


    public function testPlotsApiReturnValidData()
    {
        $this->service = Yii::createObject(PlotService::class);
        $response = $this->service->plotApiRepository->findByEgrn(static::EGRNS_ARRAY);

        $this->assertIsArray($response);

        foreach ($response as $row) {
            $this->assertIsArray($row);

            $this->assertArrayHasKey('egrn', $row);
            $this->assertArrayHasKey('address', $row);
            $this->assertArrayHasKey('price', $row);
            $this->assertArrayHasKey('area', $row);

            $this->assertContains($row['egrn'], static::EGRNS_ARRAY);
        }

        $response = $this->service->plotApiRepository->findByEgrn([static::NONEXISTENT_EGRN]);
        $this->assertIsArray($response);
        $this->assertEmpty($response);
    }


    public function testPlotRepositoryValidateData()
    {
        $this->service = Yii::createObject(PlotService::class);

        /** @var Plot $plot */
        $plot = new $this->service->plotRepository();

        $plot->egrn = '';
        $plot->address = '';

        $plot->validate();

        $this->assertArrayHasKey('egrn', $plot->errors);
        $this->assertArrayHasKey('address', $plot->errors);
        $this->assertArrayNotHasKey('price', $plot->errors);
        $this->assertArrayNotHasKey('area', $plot->errors);

        $plot->egrn = '11111111';
        $plot->address = '';
        $plot->price = 'string';
        $plot->area = 'string';

        $plot->validate();

        $this->assertArrayHasKey('egrn', $plot->errors);
        $this->assertArrayHasKey('address', $plot->errors);
        $this->assertArrayHasKey('price', $plot->errors);
        $this->assertArrayHasKey('area', $plot->errors);

        $plot->egrn = "11:11:111111:11";
        $plot->address = "Test address";
        $plot->price = 10000.05;
        $plot->area = 10000;

        $plot->validate();

        $this->assertArrayNotHasKey('egrn', $plot->errors);
        $this->assertArrayNotHasKey('address', $plot->errors);
        $this->assertArrayNotHasKey('price', $plot->errors);
        $this->assertArrayNotHasKey('area', $plot->errors);
    }
}
