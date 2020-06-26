<?php

namespace app\models;

interface EgrnSearchInterface
{
    /**
     * @param array $egrns
     */
    public static function findByEgrn(array $egrns);
}