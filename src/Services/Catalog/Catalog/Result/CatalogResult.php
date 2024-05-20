<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Catalog\Catalog\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class CatalogResult extends AbstractResult
{
    public function catalog(): CatalogItemResult
    {
        return new CatalogItemResult($this->getCoreResponse()->getResponseData()->getResult()['catalog']);
    }
}