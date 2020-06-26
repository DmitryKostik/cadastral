<?php

namespace  app\services;

use app\models\EgrnApiSearchInterface;
use yii\base\Component;

use app\models\Plot;
use app\components\PlotApi;

use app\models\EgrnSearchInterface;

use yii\data\ActiveDataProvider;

class PlotService extends Component
{
    /** @var Plot $plotRepository  */
    public $plotRepository;

    /** @var PlotApi $plotApiRepository */
    public $plotApiRepository;


    public function __construct(EgrnSearchInterface $plotRepository, EgrnApiSearchInterface $plotApiRepository, $config = [])
    {
        parent::__construct($config);
        $this->plotRepository = $plotRepository;
        $this->plotApiRepository = $plotApiRepository;
    }


    /**
     * @param $egrns
     * @return ActiveDataProvider
     */
    public function getByEgrn($egrns)
    {
        $foundEgrns = $this->plotRepository::findByEgrnColumn($egrns);

        $egrnsToParse = array_diff($egrns, $foundEgrns);

        if (!empty($egrnsToParse)) {
            $plotsData = $this->plotApiRepository->findByEgrn($egrnsToParse);
            $this->saveModelsByData($plotsData);
        }

        $query = $this->plotRepository->findByEgrn($egrns);
        
        return $this->getPlotsDataProvider($query);
    }


    /**
     * Fill Plot models by given data and save.
     * @param $plotsData
     */
    private function saveModelsByData(array $plotsData)
    {
        foreach ($plotsData as $plotData) {
            (new $this->plotRepository)->fillAndSave($plotData);
        }
    }


    /**
     * Data provider by query.
     * @param $query
     * @return ActiveDataProvider
     */
    public function getPlotsDataProvider($query)
    {
        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}