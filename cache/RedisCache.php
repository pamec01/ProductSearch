<?php

class RedisCache implements ICache
{
    private Redis $redis;
    private string $prefix;

    public function __construct(string $host = '127.0.0.1', int $port = 6379, string $prefix = 'product:')
    {
        $this->redis = new Redis();
        $this->redis->connect($host, $port);
        $this->prefix = $prefix;
    }

    public function get(string $id): ?array
    {
        $data = $this->redis->get($this->prefix . $id);
        return $data ? json_decode($data, true) : null;
    }

    public function set(string $id, array $data): void
    {
        $this->redis->set($this->prefix . $id, json_encode($data, JSON_UNESCAPED_UNICODE));
    }
}
