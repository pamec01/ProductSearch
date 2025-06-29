<?php

interface ICache {
    public function get(string $id): ?array;
    public function set(string $id, array $data): void;
}