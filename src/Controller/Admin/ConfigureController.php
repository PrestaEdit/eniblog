<?php

namespace Eni\Blog\Controller\Admin;

use Eni\Blog\Grid\Filters\BlogCategoryFilters;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use Symfony\Component\HttpFoundation\Response;

class ConfigureController extends FrameworkBundleAdminController
{
    /**
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))")
     *
     * @return Response
     */
    public function configureAction()
    {
        return $this->render('@Modules/eniblog/views/templates/admin/configure.html.twig');
    }

    /**
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))")
     *
     * @return Response
     */
    public function indexAction(BlogCategoryFilters $filters)
    {
        $categoriesGridFactory = $this->get('eni.blog.grid.factory.categories');
        $categoriesGrid = $categoriesGridFactory->getGrid($filters);

        return $this->render('@Modules/eniblog/views/templates/admin/index.html.twig', [
            'associatedGrid' => $this->presentGrid($categoriesGrid),
        ]);
    }
}