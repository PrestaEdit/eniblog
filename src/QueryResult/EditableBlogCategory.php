<?php
#/src/QueryResult/EditableBlogCategory.php
namespace Eni\Blog\QueryResult;

class EditableBlogCategory
{
    /**
     * @var int
     */
    private $blogCategoryId;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var string[]
     */
    private $title;

    /**
     * @var string[]
     */
    private $description;

    /**
     * @param int $blogCategoryId
     * @param bool $active
     * @param string[] $title
     * @param string[] $description
     */
    public function __construct(
        int $blogCategoryId,
        bool $active,
        array $title,
        array $description
    ) {
        $this->blogCategoryId = (int) $blogCategoryId;
        $this->active = $active;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getBlogCategoryId()
    {
        return $this->blogCategoryId;
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return string[]
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string[]
     */
    public function getDescription()
    {
        return $this->description;
    }
}