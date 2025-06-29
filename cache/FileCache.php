<?php

class FileCache implements ICache
{
    private string $file;

    public function __construct(string $file = 'data/cache/cache.json')
    {
        $this->file = $file;

        // Pokud soubor neexistuje, vytvoříme ho jako prázdné pole
        if (!file_exists($this->file)) {
            file_put_contents($this->file, json_encode([]));
        }
    }

    public function get(string $id): ?array
    {
        $cache = $this->loadCache();

        return $cache[$id] ?? null;
    }

    public function set(string $id, array $data): void
    {
        $cache = $this->loadCache();
        $cache[$id] = $data;
        $this->saveCache($cache);
    }

    private function loadCache(): array
    {
        $json = file_get_contents($this->file);
        return json_decode($json, true) ?? [];
    }

    private function saveCache(array $cache): void
    {
        file_put_contents($this->file, json_encode($cache, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
