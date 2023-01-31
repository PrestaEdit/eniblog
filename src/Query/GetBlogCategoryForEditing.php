<?php
#/src/Query/GetBlogCategoryForEditing.php
namespace Eni\Blog\Query;

/**
 */
class GetBlogCategoryForEditing
{
    /** @var int */
    private $blogCategoryId;

    /**
     * @param int $blogCategoryId
     */
    public function __construct($blogCategoryId)
    {
        $this->blogCategoryId = (int) $blogCategoryId;
    }

    /**
     * @return int
     */
    public function getBlogCategoryid()
    {
        return $this->blogCategoryId;
    }
}
