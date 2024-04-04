<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheMethods 
{

    public function cacheGet($key): mixed
    {
        $data = json_decode(Cache::get($key));
        
        return $data;
    }

    public function cacheUpdate(string $key, mixed $value = null): void
    {
        $this->cacheForgetKey($key);
        if (isset($value)){
            $this->cacheRemember($key,$value);
        } 
    }

    abstract public function cacheRemember(string $key, mixed $value = null, int $ttl = 3600): mixed;

    public function cacheSet($key, $value,$ttl=3600): void
    {
        Cache::set($key,json_encode($value));
    }
    public function cacheSetForever($key, $value): void
    {
        Cache::forever($key,json_encode($value));
    }

    public function cacheForgetKey($key): void
    {
        Cache::forget($key);
    }
    
}