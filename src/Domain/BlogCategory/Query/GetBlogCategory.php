<?php

namespace Eni\Blog\Domain\BlogCategory\Query;

use PrestaShop\PrestaShop\Core\Domain\ValueObject\QuerySorting;


class GetBlogCategory
{
    /**
     * @var QuerySorting|null
     */
    private $querySorting;

    /**
     * @param string|null $querySorting
     */
    public function __construct($querySorting)
    {
        $this->querySorting = null !== $querySorting ? new QuerySorting((string) $querySorting) : null;
    }

    /**
     * @return QuerySorting|null
     */
    public function getQuerySorting()
    {
        return $this->querySorting;
    }
}