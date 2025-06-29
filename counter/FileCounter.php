<?php

/**
 * Uchovávání počtu dotazů na jednotlivé produkty
 */

class FileCounter implements ICounter {
    private string $file = __DIR__ . '/../data/counter.txt';

    public function increment(string $id): void {
        $counters = [];

        if (file_exists($this->file)) {
            $counters = json_decode(file_get_contents($this->file), true) ?? [];
        }

        $counters[$id] = ($counters[$id] ?? 0) + 1;

        file_put_contents($this->file, json_encode($counters));
    }
}
