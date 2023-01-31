<?php
#/src/Query/GetBlogCategoryForEditingHandler.php
namespace Eni\Blog\QueryHandler;

use Eni\Blog\Query\GetBlogCategoryForEditing;
use Eni\Blog\QueryResult\EditableBlogCategory;
use PrestaShopException;

/**
 */
final class GetBlogCategoryForEditingHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(GetBlogCategoryForEditing $query)
    {
        try {
            $blogCategory = $this->blogCategoryRepository->findOneById($query->getBlogCategoryId());

            if (0 >= $blogCategory->id) {
                throw new PrestaShopException(sprintf('Category object with id %s was not found', var_export($query->getBlogCategoryId(), true)));
            }
            $editableBlogCategory = new EditableBlogCategory(
                $query->getBlogCategoryId(),
                $blogCategory->active,
                $blogCategory->title,
                $blogCategory->description,
            );
        } catch (PrestaShopException $e) {
            throw new BlogCategoryException(sprintf('An unexpected error occurred when retrieving contact with id %s', var_export($query->getContactId()->getValue(), true)), 0, $e);
        }

        return $editableBlogCategory;
    }
}
