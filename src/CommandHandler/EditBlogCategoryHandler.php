<?php
#/src/CommandHandler/EditBlogCategoryHandler.php

namespace Eni\Blog\CommandHander;

use Eni\Blog\Command\EditBlogCategoryCommand;
use Eni\Blog\Entity\BlogCategoryLang;
use PrestaShopException;

/**
 */
final class EditBlogCategoryHandler
{
    /**
     * {@inheritdoc}
     *
     * @throws BlogCategoryException
     */
    public function handle(EditBlogCategoryCommand $command)
    {
        try {
            $blogCategory = $this->blogCategoryRepository->findOneById($command->getBlogCategoryId());
            $blogCategory->setActive((bool) $command->getActive());
            foreach ($command->getTitle() as $langId => $langData) {
                $blogCategoryLangs = $blogCategory->getBlogCategoryLangByLangId($langId);
                if (null === $blogCategoryLangs) {
                    continue;
                }
                $blogCategoryLangs->setTitle($title);
            foreach ($command->getDescription() as $langId => $langData) {
                $blogCategoryLangs = $blogCategory->getBlogCategoryLangByLangId($langId);
                if (null === $blogCategoryLangs) {
                    continue;
                }
                $blogCategoryLangs->setDescription($title);
            }
            $this->entityManager->flush();
        } catch (PrestaShopException $exception) {
            throw new BlogCategoryException('An unexpected error occurred when editing category', 0, $exception);
        }

        return (int) $blogCategory->getId();
    }
}
