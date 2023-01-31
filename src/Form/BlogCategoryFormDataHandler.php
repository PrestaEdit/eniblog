<?php

namespace Eni\Blog\Form;

use Doctrine\ORM\EntityManagerInterface;
use Eni\Blog\Entity\BlogCategory;
use Eni\Blog\Entity\BlogCategoryLang;
use Eni\Blog\Repository\BlogCategoryRepository;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataHandler\FormDataHandlerInterface;
use PrestaShopBundle\Entity\Repository\LangRepository;

class BlogCategoryFormDataHandler implements FormDataHandlerInterface
{
    /**
     * @var BlogCategoryRepository
     */
    private $blogCategoryRepository;

    /**
     * @var LangRepository
     */
    private $langRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param BlogCategoryRepository $blogCategoryRepository
     * @param LangRepository $langRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        BlogCategoryRepository $blogCategoryRepository,
        LangRepository $langRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->blogCategoryRepository = $blogCategoryRepository;
        $this->langRepository = $langRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $blogCategory = new BlogCategory();
        $blogCategory->setActive((bool) $data['active']);
        foreach ($data['title'] as $langId => $langData) {
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
        foreach ($data['description'] as $langId => $langData) {
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

        return $blogCategory->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $blogCategory = $this->blogCategoryRepository->findOneById($id);
        $blogCategory->setActive((bool) $data['active']);
        foreach ($data['title'] as $langId => $title) {
            $blogCategoryLangs = $blogCategory->getBlogCategoryLangByLangId($langId);
            if (null === $blogCategoryLangs) {
                continue;
            }
            $blogCategoryLangs->setTitle($title);
        }
        foreach ($data['description'] as $langId => $title) {
            $blogCategoryLangs = $blogCategory->getBlogCategoryLangByLangId($langId);
            if (null === $blogCategoryLangs) {
                continue;
            }
            $blogCategoryLangs->setDescription($title);
        }
        $this->entityManager->flush();

        return $blogCategory->getId();
    }
}
