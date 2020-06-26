<?php

namespace app\models;

use yii\base\Model;


/**
 * @property array formattedEgrns
 */
class SearchForm extends Model
{
    const SEARCH_PATTERN = '/^([0-9]{1,5}:[0-9]{1,5}:[0-9]{6,7}:[0-9]{1,5} ?){1}(, ?[0-9]{1,5}:[0-9]{1,5}:[0-9]{6,7}:[0-9]{1,5} ?)*$/';

    /** @var string */
    public $egrns;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['egrns', 'match', 'pattern' => static::SEARCH_PATTERN, 'message' => 'Неккоректный номер(а)']
        ];
    }


    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'egrns' => 'Кадастровые номера',
        ];
    }


    /**
     * Convert egrns spitted by comma to array.
     * @return array
     */
    public function getFormattedEgrns() : array
    {
        $egrns = preg_split('/ ?, ?/', $this->egrns, -1, PREG_SPLIT_NO_EMPTY);
        $egrns = array_map(function($egrn) {
            return trim($egrn);
        }, $egrns);

        return $egrns;
    }
}
