<?php

namespace Eni\Blog\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;

class ConfigureVueJSController extends FrameworkBundleAdminController
{
    /**
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))")
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('@Modules/eniblog/views/templates/admin/vuejs.html.twig', [
            'yourModule' => [
                'keyA' => 'valueA',
                'keyB' => 'valueB',
            ]
        ]);
    }
}