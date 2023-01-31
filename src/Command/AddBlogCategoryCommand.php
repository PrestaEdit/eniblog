<?php

# /src/Command/AddBlogCategoryCommand.php

namespace Eni\Blog\Command;

/**
 *
 */
class AddBlogCategoryCommand
{
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
     */
    public function __construct(bool $active, array $title, array $description)
    {
        $this->active = $active;
        $this->title = $title;
        $this->description = $description;
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
