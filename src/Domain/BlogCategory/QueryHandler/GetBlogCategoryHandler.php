<?php

namespace Eni\Blog\Domain\BlogCategory\QueryHandler;

use Eni\Blog\Domain\BlogCategory\Query\GetBlogCategory;
use Eni\Blog\Domain\BlogCategory\QueryResult\BlogCategory;
use Eni\Blog\Repository\BlogCategoryRepository;

/**
 * Gets reviewer settings data ready for form display.
 */
class GetBlogCategoryHandler
{
    /**
     * @var BlogCategoryRepository
     */
    private $blogCategoryRepository;

    /**
     * @param BlogCategoryRepository $reviewerRepository
     */
    public function __construct(BlogCategoryRepository $blogCategoryRepository)
    {
        $this->blogCategoryRepository = $blogCategoryRepository;
    }

    public function handle(GetBlogCategory $query)
    {
        if (null === $query->getQuerySorting()) {
            return new BlogCategory(false);
        }

        return new BlogCategory(
            $this->blogCategoryRepository->getIsAllowedToReviewStatus($query->getQuerySorting()->getValue())
        );
    }
}
