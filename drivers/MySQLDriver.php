<?php

require_once 'IMySQLDriver.php';

class MySQLDriver implements IMySQLDriver
{
    public function findProduct(string $id): array
    {
        // Simulované testovací data
        return [
            'id' => $id,
            'source' => 'MySQL',
            'name' => 'MySQL produkt ' . $id,
            'price' => rand(100, 500),
        ];
    }
}
