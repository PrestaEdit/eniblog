<?php
declare(strict_types=1);

if (!defined('_PS_VERSION_')) {
    exit;
}

$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
}

use Eni\Blog\Domain\BlogCategory\Query\GetBlogCategory;
use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use PrestaShop\PrestaShop\Core\Grid\Action\Bulk\Type\SubmitBulkAction;

class EniBlog extends Module
{
    protected $tabs = [
        [
            'class_name' => 'AdminEniBlog',
            'visible' => true,
            'name' => [
                'en' => 'Blog',
                'fr' => 'Blog',
            ],
            'parent_class_name' => 'AdminParentModulesSf',
            'wording' => 'Blog',
            'wording_domain' => 'Modules.Eniblog.Admin',
        ],
        [
            'class_name' => 'AdminEniBlogConfigure',
            'route_name' => 'eniblog_configure',
            'visible' => true,
            'name' => [
                'en' => 'Configure',
                'fr' => 'Configuration',
            ],
            'parent_class_name' => 'AdminEniBlog',
            'wording' => 'Configure',
            'wording_domain' => 'Modules.Eniblog.Admin',
        ],
        [
            'class_name' => 'AdminEniBlogCategory',
            'route_name' => 'eniblog_category_index',
            'visible' => true,
            'name' => [
                'en' => 'Categories',
                'fr' => 'Catégories',
            ],
            'parent_class_name' => 'AdminEniBlog',
            'wording' => 'Categories',
            'wording_domain' => 'Modules.Eniblog.Admin',
        ],
    ];

    /**
     * @see parent::construct
     * @return void
     */
    public function __construct()
    {
        $this->name = 'eniblog';
        $this->tab = 'front_office_features';
        $this->author = 'Jonathan Danse';
        $this->version = '1.0.0';

        $this->displayName = $this->l('Blog');
        $this->displayName = $this->trans(
            'Blog',
            [],
            'Modules.Eniblog'
        );
        $this->description = $this->l('n/d');

        $this->ps_versions_compliancy = [
            'min' => '8.0.0',
            'max' => '8.99.99',
        ];
        $this->need_instance = 0;
        $this->bootstrap = true;

        $this->controllers = ['blog'];

        parent::__construct();

        // addListener
        $hookDispatcher = $this->get('prestashop.hook.dispatcher');
        if ($hookDispatcher !== false) {
            $hookDispatcher->addListener(
                'eni_listener', [$this, 'listenerCallback']);
        }

        // addSubscriber
        $hookDispatcher = $this->get('prestashop.hook.dispatcher');
        if ($hookDispatcher !== false) {
            $hookDispatcher->addSubscriber(new \Eni\Blog\Event\EniEventsSubscriber());
        }
    }

    public function listenerCallback()
    {
        dump('eni_listener');
    }

    public function install()
    {
        $hooks = [
            'moduleRoutes',
            'displayLeftColumnBlog',
            'addWebserviceResources',
            'actionAdminControllerSetMedia',
            'actionBlogCategoryGridDefinitionModifier',
        ];

        return parent::install() && $this->registerHook($hooks) && $this->installSQL();

        //actionCategoriesGridQueryBuilderModifier
    }

    protected function installSQL()
    {
        if (!file_exists(dirname(__FILE__) . '/sql/install.sql')) {
            return false;
        } elseif (!$sql = file_get_contents(dirname(__FILE__) . '/sql/install.sql')) {
            return false;
        }
        $sql = str_replace(['PREFIX_', 'ENGINE_TYPE'], [_DB_PREFIX_, _MYSQL_ENGINE_], $sql);
        $sql = preg_split("/;\s*[\r\n]+/", trim($sql));

        foreach ($sql as $query) {
            if (!Db::getInstance()->execute(trim($query))) {
                return false;
            }
        }

        return true;
    }

    public function isUsingNewTranslationSystem()
    {
        return true;
    }

    public function getContent()
    {
        $availableViews = [
            'eniblog_configure',
            'eniblog_configure_vuejs',
        ];

        $specificView = Tools::getValue('specificView', 'eniblog_configure');
        if (!in_array($specificView, $availableViews)){
            $specificView = 'eniblog_configure';
        }

        // We need to explicitely get Symfony container, because $this->get will use the admin legacy container
        $sfContainer = SymfonyContainer::getInstance();
        $router = $sfContainer->get('router');
        Tools::redirectAdmin(
            $router->generate($specificView)
        );
    }

    public function hookModuleRoutes($params)
    {
        $customRoutes = [
            'module-' . $this->name . '-blog' => [
                'controller' => 'blog',
                'rule' => 'blog',
                'keywords' => array(),
                'params' => array(
                    'fc' => 'module',
                    'module' => $this->name,
                ),
            ],
        ];

        return $customRoutes;
    }

    public function hookAddWebserviceResources($params)
    {
        return [
            'blog_articles' => [
                'description' => 'Blog articles',
                'class' => '\Eni\Blog\Models\BlogArticle'
            ],
            'blog_categories' => [
                'description' => 'Blog categories',
                'class' => '\Eni\Blog\Models\BlogCategory',
            ],
        ];
    }

    public function hookDisplayLeftColumnBlog($params)
    {
        $blogCategoryRepository = $this->get('eni.blog.repository.category_repository');

        $this->context->smarty->assign([
            'blogCategories' => $blogCategoryRepository->findAll(),
        ]);

        return $this->fetch('module:' . $this->name . '/views/templates/hook/displayLeftColumnBlog.tpl');
    }

    public function hookActionAdminControllerSetMedia(array $params)
    {
        $this->context->controller->addJS($this->getPathUri().'views/js/tinymce.config.js');
    }

    public function hookActionBlogCategoryGridDefinitionModifier(array $params)
    {
        // $params['definition'] étant une instance de BlogCategoryGridDefinitionFactory
        $params['definition']->getBulkActions()->add(
            (new SubmitBulkAction('delete_selection'))
                ->setName($this->trans('Delete selected', [], 'Admin.Actions'))
                ->setOptions([
                    'submit_route' => 'eniblog_category_delete_bulk',
                ]) 
        );
    }
}
