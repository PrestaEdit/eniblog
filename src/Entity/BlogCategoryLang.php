<?php

namespace Eni\Blog\Entity;

use Doctrine\ORM\Mapping as ORM;
use PrestaShopBundle\Entity\Lang;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class BlogCategoryLang
{
    /**
     * @var BlogCategory
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Eni\Blog\Entity\BlogCategory", inversedBy="blogCategoryLangs")
     * @ORM\JoinColumn(name="id_blog_category", referencedColumnName="id_blog_category", nullable=false)
     */
    private $blogCategory;

    /**
     * @var Lang
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="PrestaShopBundle\Entity\Lang")
     * @ORM\JoinColumn(name="id_lang", referencedColumnName="id_lang", nullable=false, onDelete="CASCADE")
     */
    private $lang;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @return BlogCategory
     */
    public function getBlogCategory()
    {
        return $this->blogCategory;
    }

    /**
     * @param BlogCategory $blogCategory
     * @return $this
     */
    public function setBlogCategory(BlogCategory $blogCategory)
    {
        $this->blogCategory = $blogCategory;

        return $this;
    }

    /**
     * @return Lang
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param Lang $lang
     * @return $this
     */
    public function setLang(Lang $lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }
}
