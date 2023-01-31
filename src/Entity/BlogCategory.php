<?php

# src/Entity/BlogCategory.php

namespace Eni\Blog\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Eni\Blog\Repository\BlogCategoryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class BlogCategory
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id_blog_category", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity="Eni\Blog\Entity\BlogCategoryLang", cascade={"persist", "remove"}, mappedBy="blogCategory")
     */
    private $blogCategoryLangs;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date_add", type="datetime")
     */
    private $dateAdd;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date_upd", type="datetime")
     */
    private $dateUpd;

    public function __construct()
    {
        $this->blogCategoryLangs = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function setId($value)
    {
        $this->id = $value;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getBlogCategoryLangs()
    {
        return $this->blogCategoryLangs;
    }

    /**
     * @param int $langId
     * @return BlogCategoryLang|null
     */
    public function getBlogCategoryLangByLangId(int $langId)
    {
        foreach ($this->blogCategoryLangs as $blogCategoryLang) {
            if ($langId === $blogCategoryLang->getLang()->getId()) {
                return $blogCategoryLang;
            }
        }

        return null;
    }

    /**
     * @param BlogCategoryLang $blogCategoryLang
     * @return $this
     */
    public function addBlogCategoryLang(BlogCategoryLang $blogCategoryLang)
    {
        $blogCategoryLang->setBlogCategory($this);
        $this->blogCategoryLangs->add($blogCategoryLang);

        return $this;
    }

    /**
     * @return string
     */
    public function getBlogCategoryTitle()
    {
        if ($this->blogCategoryLangs->count() <= 0) {
            return '';
        }

        $blogCategoryLang = $this->blogCategoryLangs->first();

        return $blogCategoryLang->getTitle();
    }

    /**
     * @return string
     */
    public function getActive(): ?bool
    {
        return $this->active;
    }

    /**
     * @param string $active
     *
     * @return BlogCategory
     */
    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Set dateAdd.
     *
     * @param DateTime $dateAdd
     *
     * @return $this
     */
    public function setDateAdd(DateTime $dateAdd)
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    /**
     * Get dateAdd.
     *
     * @return DateTime
     */
    public function getDateAdd()
    {
        return $this->dateAdd;
    }

    /**
     * Set dateUpd.
     *
     * @param DateTime $dateUpd
     *
     * @return $this
     */
    public function setDateUpd(DateTime $dateUpd)
    {
        $this->dateUpd = $dateUpd;

        return $this;
    }

    /**
     * Get dateUpd.
     *
     * @return DateTime
     */
    public function getDateUpd()
    {
        return $this->dateUpd;
    }

    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setDateUpd(new DateTime());

        if ($this->getDateAdd() == null) {
            $this->setDateAdd(new DateTime());
        }
    }
}
