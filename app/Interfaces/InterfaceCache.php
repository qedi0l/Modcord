<?php

namespace App\Interfaces;

interface InterfaceCache
{
    public function getCache(string $key);

    public function updateCache(string $key, mixed $value);

    public function setForeverCache(string $key, mixed $value);

    public function setCache(string $key, mixed $value);

    public function rememberCache(string $key, mixed $value);

    public function forgetCacheKey(string $key);
}