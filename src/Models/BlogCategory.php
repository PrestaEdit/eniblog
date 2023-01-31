<?php

namespace Eni\Blog\Models;

class BlogCategory extends \ObjectModel
{
    /** @var int Category ID */
    public $id_blog_category;

    /** @var string title */
    public $title;

    /* @var int Shop ID */
    public $id_shop;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'blog_category',
        'primary' => 'id_blog_category',
        'fields' => array(
            'title'     =>  array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            //'id_shop'   =>  array('type' => self::TYPE_INT, 'validate' => 'isInt'),
        ),
    );
}
