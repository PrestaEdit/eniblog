<?php

class BlogArticle extends ObjectModel
{
    /** @var int Article ID */
    public $id_article;

    /** @var int value */
    public $value;

    /** @var int type */
    public $type;

    /* @var int Shop ID */
    public $id_shop;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'pm_subscription_frequencies',
        'primary' => 'id_frequency',
        'fields' => array(
            'value'     =>  array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'type'      =>  array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'id_shop'   =>  array('type' => self::TYPE_INT, 'validate' => 'isInt'),
        ),
    );
}