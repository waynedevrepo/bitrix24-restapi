<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Main;

use Bitrix24\SDK\Services\AbstractServiceBuilder;
use Bitrix24\SDK\Services\Main\Service\Main;
use Bitrix24\SDK\Services\Main\Service\Event;

/**
 * Class MainServiceBuilder
 *
 * @package Bitrix24\SDK\Services\Main
 */
class MainServiceBuilder extends AbstractServiceBuilder
{
    /**
     * @return Main
     */
    public function main(): Main
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Main($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    /**
     * @return Event
     */
    public function event(): Event
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Event($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }
}