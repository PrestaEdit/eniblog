<?php
namespace Eni\Blog\Grid\Filters;

use Eni\Blog\Grid\Definition\Factory\BlogCategoryGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Search\Filters;

class BlogCategoryFilters extends Filters
{
    protected $filterId = BlogCategoryGridDefinitionFactory::GRID_ID;

    /**
     * {@inheritdoc}
     */
    public static function getDefaults()
    {
        return [
            'limit' => 10,
            'offset' => 0,
            'orderBy' => 'id_blog_category',
            'sortOrder' => 'asc',
            'filters' => [],
        ];
    }
}
