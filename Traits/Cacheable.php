<?php

namespace Vagento\Cacheable\Traits;

use BadMethodCallException;
use DateInterval;
use DateTimeInterface;
use Illuminate\Support\Facades\Cache;

trait Cacheable
{
    /**
     * Use cache for all operations in this class.
     *
     * @var bool
     */
    protected bool $cacheUsage = true;

    /**
     * The cache tag.
     *
     * @see https://laravel.com/docs/8.x/cache#cache-tags
     *
     * @var array|mixed
     */
    protected mixed $cacheTag = null;

    /**
     * Time to live for cache.
     *
     * @var DateTimeInterface|DateInterval|int|null
     */
    protected DateTimeInterface|DateInterval|int|null $ttl = null;

    /**
     * Set cache usage.
     *
     * @param bool $cacheUsage
     * @return static
     */
    public function setCacheUsage(bool $cacheUsage): static
    {
        $this->cacheUsage = $cacheUsage;

        return $this;
    }

    /**
     * Set cache tag.
     *
     * @see https://laravel.com/docs/8.x/cache#cache-tags
     *
     * @param array|mixed $cacheTag
     * @return $this
     */
    public function setCacheTag(mixed $cacheTag): static
    {
        $this->cacheTag = $cacheTag;

        return $this;
    }

    /**
     * Set time to live for cache.
     *
     * @param DateTimeInterface|DateInterval|int|null $ttl
     * @return $this
     */
    public function setTtl(DateTimeInterface|DateInterval|int|null $ttl): static
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * This allows to call a method with the "Cache" suffix.
     *
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args): mixed
    {
        // Check if a string ends with "Cached"
        if (str_ends_with($method, 'Cached')) {
            $method = str_replace('Cached', '', $method);

            // Check if method exists
            if (method_exists($this, $method)) {

                // Check if cache usage is enabled
                if ($this->cacheUsage === true) {
                    $key = __CLASS__ . '::' . $method;

                    // Check if cache tag is set
                    if ($this->cacheTag !== null) {
                        return Cache::tags($this->cacheTag)->remember(
                            $key, $this->ttl, fn() => $this->$method(...$args)
                        );
                    } else {
                        // Else cache without tags
                        return Cache::remember(
                            $key, $this->ttl, fn() => $this->$method(...$args)
                        );
                    }
                } else {
                    // Call method even if cache usage is disabled
                    return $this->$method(...$args);
                }
            }
        }

        throw new BadMethodCallException('Call to undefined method ' . __CLASS__ . '::' . $method . '()');
    }
}