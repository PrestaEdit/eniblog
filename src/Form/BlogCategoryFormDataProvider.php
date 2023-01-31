<?php

namespace Eni\Blog\Form;

use Eni\Blog\Repository\BlogCategoryRepository;

use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataProvider\FormDataProviderInterface;

/**
 *
 * Class BlogCategoryFormDataProvider
 */
class BlogCategoryFormDataProvider implements FormDataProviderInterface
{
    /**
     * @var BlogCategoryRepository
     */
    private $repository;

    /**
     * @param BlogCategoryRepository $repository
     */
    public function __construct(BlogCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getData($categoryId): array
    {
        $blogCategory = $this->repository->findOneById($categoryId);

        $blogCategoryData = [
            'active' => (bool) $blogCategory->getActive(),
        ];
        foreach ($blogCategory->getBlogCategoryLangs() as $categoryLang) {
            $blogCategoryData['title'][$categoryLang->getLang()->getId()] = $categoryLang->getTitle();
            $blogCategoryData['description'][$categoryLang->getLang()->getId()] = $categoryLang->getDescription();
        }

        return $blogCategoryData;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultData()
    {
        return [
            'title' => [],
            'description' => [],
            'active' => true,
        ];
    }
}
