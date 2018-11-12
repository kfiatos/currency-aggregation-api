<?php

namespace App\Service;

use Symfony\Component\Cache\Adapter\AdapterInterface;

/**
 * Class Cache
 * @package App\Service
 */
class Cache
{
    /**
     * @var AdapterInterface
     */
    protected $baseCache;

    /**
     * Cache constructor.
     * @param AdapterInterface $baseCache
     */
    public function __construct(AdapterInterface $baseCache)
    {
        $this->baseCache = $baseCache;
    }

    /**
     * @return AdapterInterface
     */
    public function getCacheService(): AdapterInterface
    {
        return $this->baseCache;
    }


}