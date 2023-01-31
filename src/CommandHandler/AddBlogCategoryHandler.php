<?php
#/src/CommandHandler/AddBlogCategoryHandler.php

namespace Eni\Blog\CommandHander;

use Eni\Blog\Command\AddBlogCategoryCommand;
use Eni\Blog\Entity\BlogCategory;
use Eni\Blog\Entity\BlogCategoryLang;
use PrestaShopException;

/**
 */
final class AddBlogCategoryHandler
{
    /**
     * {@inheritdoc}
     *
     * @throws BlogCategoryException
     */
    public function handle(AddBlogCategoryCommand $command)
    {
        try {
            $blogCategory = new BlogCategory();
            $blogCategory->setActive((bool) $command->getActive());
            foreach ($command->getTitle() as $langId => $langData) {
                if (null === $langData) {
                    continue;
                }
                $lang = $this->langRepository->findOneById($langId);
                $blogCategoryLangs = new BlogCategoryLang();
                $blogCategoryLangs
                    ->setLang($lang)
                    ->setTitle($langData)
                ;
                $blogCategory->addBlogCategoryLang($blogCategoryLangs);
            }
            foreach ($command->getDescription() as $langId => $langData) {
                if (null === $langData) {
                    continue;
                }
                $lang = $this->langRepository->findOneById($langId);
                $blogCategoryLangs = new BlogCategoryLang();
                $blogCategoryLangs
                    ->setLang($lang)
                    ->setDescription($langData)
                ;
                $blogCategory->addBlogCategoryLang($blogCategoryLangs);
            }
            $this->entityManager->persist($blogCategory);
            $this->entityManager->flush();
        } catch (PrestaShopException $exception) {
            throw new BlogCategoryException('An unexpected error occurred when adding category', 0, $exception);
        }

        return (int) $blogCategory->getId();
    }
}
