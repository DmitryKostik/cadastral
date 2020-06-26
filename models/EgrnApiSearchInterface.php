<?php

namespace app\models;

interface EgrnApiSearchInterface
{
    /**
     * @param array $egrns
     */
    public function findByEgrn(array $egrns);
}