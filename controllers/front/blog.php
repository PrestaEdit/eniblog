<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class eniblogBlogModuleFrontController extends ModuleFrontController
{
    public function getLayout()
    {
        return 'layouts/layout-left-column.tpl';
    }

    public function initContent()
    {
        parent::initContent();

        $this->setTemplate('module:eniblog/views/templates/front/blog.tpl');
    }

    public function process()
    {
        $blogCategoryRepository = $this->get('eni.blog.repository.category_repository');

        $this->context->smarty->assign([
            'blogCategories' => $blogCategoryRepository->findAll(),
        ]);
    }
}
