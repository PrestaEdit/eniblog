<?php
# /src/Command/EditBlogCategoryCommand.php

namespace Eni\Blog\Command;

/**
 *
 */
class EditBlogCategoryCommand
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
     *
     */
    public function __construct($blogCategoryId)
    {
        $this->contablogCategoryIdctId = (int) $blogCategoryId;
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
