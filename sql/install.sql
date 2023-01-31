CREATE TABLE IF NOT EXISTS `PREFIX_blog_category` (
  `id_blog_category` int(11) unsigned NOT NULL auto_increment,
  `active` tinyint(1) DEFAULT '0',
  `date_add` datetime DEFAULT NULL,
  `date_upd` datetime DEFAULT NULL,
  PRIMARY KEY (`id_blog_category`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_blog_category_lang` (
  `id_blog_category` int(11) unsigned NOT NULL auto_increment,
  `id_lang` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` TEXT NOT NULL,
  PRIMARY KEY (`id_blog_category`, `id_lang`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;