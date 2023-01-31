<?php

namespace Eni\Blog\Form;

use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataProvider\FormDataProviderInterface;

/**
 *
 * Class BlogCategoryFormDataProvider
 */
class BlogCategoryFormDataProvider implements FormDataProviderInterface
{
    /**
     * @var CommandBusInterface
     */
    private $queryBus;

    /**
     * @param CommandBusInterface $queryBus
     */
    public function __construct(CommandBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * {@inheritdoc}
     */
    public function getData($categoryId): array
    {
        /** @var EditableBlogCategory $editableBlogCategory */
        $editableBlogCategory = $this->queryBus->handle(new GetBlogCategoryForEditing($categoryId));

        return [
            'active' => $editableBlogCategory->getActive(),
            'title' => $editableBlogCategory->getTitle(),
            'description' => $editableBlogCategory->getDescription(),
        ];
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
