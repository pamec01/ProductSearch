<?php

require_once 'IElasticSearchDriver.php';

class ElasticSearchDriver implements IElasticSearchDriver
{
    public function findById(string $id): array
    {
        //simulace vrácených dat
        return [
            'id' => $id,
            'source' => 'ElasticSearch',
            'name' => 'Elastic produkt ' . $id,
            'price' => rand(100, 500),
        ];
    }
}
