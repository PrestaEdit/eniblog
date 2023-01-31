<?php

namespace Eni\Blog\Controller\Admin;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;

class BlogController extends FrameworkBundleAdminController
{
    /**
     * Index
     *
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render(
            '@Modules/eniblog/views/templates/admin/index.html.twig',
            [
                'enableSidebar' => true,
                'layoutTitle' => $this->trans('Categories', 'Modules.Eniblog.Admin'),
                'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
            ]
        );
    }

    /**
     * @return array[]
     */
    private function getToolbarButtons()
    {
        return [
            'add' => [
                'desc' => $this->trans('Add new category', 'Modules.Eniblog.Admin'),
                'icon' => 'add_circle_outline',
                'href' => $this->generateUrl('eniblog_category_create'),
            ],
        ];
    }
}
