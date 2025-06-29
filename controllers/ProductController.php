<?php

class ProductController
{
    private ICache $cache;
    private ICounter $counter;
    private IElasticSearchDriver|IMySQLDriver $dataSource;

    public function __construct(ICache $cache, ICounter $counter, $dataSource)
    {
        $this->cache = $cache;
        $this->counter = $counter;
        $this->dataSource = $dataSource;
    }

    // Vrací JSON string (API)
    public function detail(string $id): string
    {
        $product = $this->getProduct($id);
        return json_encode($product, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // Vrací HTML stránku s JSON ve <pre> (prohlížeč)
    public function detailHtml(string $id): string
    {
        $product = $this->getProduct($id);
        $json = json_encode($product, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return "
            <!DOCTYPE html>
            <html lang='cs'>
            <head>
                <meta charset='UTF-8'>
                <title>Produkt {$product['id']}</title>
            </head>
            <body>
                <pre>{$json}</pre>
            </body>
            </html>
        ";
    }

    private function getProduct(string $id): array
    {
        $product = $this->cache->get($id);

        if (!$product) {
            $product = $this->dataSource instanceof IElasticSearchDriver
                ? $this->dataSource->findById($id)
                : $this->dataSource->findProduct($id);

            $this->cache->set($id, $product);
        }

        $this->counter->increment($id);
        return $product;
    }
}

