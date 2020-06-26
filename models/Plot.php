<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Plot
 * @package app\models
 *
 * @property string $egrn Cadastral number.
 * @property string $address Address.
 * @property float $price Price.
 * @property float $area Area.
 *
 * @property-read string $formattedArea.
 * @property-read string $formattedPrice.
 */
class Plot extends ActiveRecord implements EgrnSearchInterface
{
    const EGRN_PATTERN = '/[0-9]{1,5}:[0-9]{1,5}:[0-9]{6,7}:[0-9]{1,5}/';

    public function rules()
    {
        return [
            [['egrn', 'address'], 'required'],
            ['egrn', 'match', 'pattern' => static::EGRN_PATTERN],
            ['address', 'string', 'length' => [1,255]],
            ['price', 'double'],
            ['area', 'double']
        ];
    }


    public function attributeLabels()
    {
        return [
            'egrn' => 'Кадастровый номер',
            'address' => 'Адрес',
            'price' => 'Стоимость',
            'area' => 'Площадь',
            'formattedPrice' => 'Цена',
            'formattedArea' => 'Площадь'
        ];
    }


    /**
     * @param array $egrn
     * @return ActiveQuery
     */
    public static function findByEgrn(array $egrn) : ActiveQuery
    {
        return static::find()->where(['egrn' => $egrn]);
    }


    /**
     * @param array $egrn
     * @return array
     */
    public static function findByEgrnColumn(array $egrn) : array
    {
        return static::findByEgrn($egrn)->select('egrn')->column();
    }


    /**
     * @param $attributes
     * @return bool
     */
    public function fillAndSave($attributes) : bool
    {
        $this->setAttributes($attributes);
        return $this->save();
    }


    /**
     * @return string
     */
    public function getFormattedArea() : string
    {
        return Yii::$app->formatter->asCurrency($this->area, '') . " м²";
    }


    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getFormattedPrice() : string
    {
        return Yii::$app->formatter->asCurrency($this->price, '') . " руб.";
    }
}
