<?php

namespace Eni\Blog\Models;

use ObjectModel;

class BlogCategory extends ObjectModel
{
    /** @var int BlogCategory ID */
    public $id_blog_category;

    /** @var bool active */
    public $active;

    /** @var string title */
    public $title;

    /** @var string Object creation date */
    public $date_add;

    /** @var string Object last modification date */
    public $date_upd;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'blog_category',
        'primary' => 'id_blog_category',
        'multilang' => true,
        'fields' => [
            'active'    => [
                'type' => self::TYPE_BOOL,
                'validate' => 'isBool'
            ],
            'date_add'  => [
                'type' => self::TYPE_DATE,
                'validate' => 'isDate',
                'copy_post' => false
            ],
            'date_upd'  => [
                'type' => self::TYPE_DATE,
                'validate' => 'isDate',
                'copy_post' => false
            ],
            /* Lang fields */
            'title' => [
                'type' => self::TYPE_STRING,
                'lang' => true,
                'validate' => 'isGenericName',
                'required' => true,
                'size' => 255
            ],
        ],
    ];
}
