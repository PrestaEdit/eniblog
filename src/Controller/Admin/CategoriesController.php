<?php

namespace Eni\Blog\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Eni\Blog\Grid\Definition\Factory\BlogCategoryGridDefinitionFactory;
use Eni\Blog\Grid\Filters\BlogCategoryFilters;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use PrestaShopBundle\Service\Grid\ResponseBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends FrameworkBundleAdminController
{
    /**
     * List categories
     *
     * @param BlogCategoryFilters $filters
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))", message="Access denied.")
     *
     * @return Response
     */
    public function indexAction(BlogCategoryFilters $filters) : Response
    {
        $blogCategoryGridFactory = $this->get('eni.blog.grid.factory.categories');
        $blogCategoryGrid = $blogCategoryGridFactory->getGrid($filters);

        return $this->render(
            '@Modules/eniblog/views/templates/admin/index.html.twig',
            [
                'enableSidebar' => true,
                'layoutTitle' => $this->trans('Categories', 'Modules.Eniblog.Admin'),
                'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
                'associatedGrid' => $this->presentGrid($blogCategoryGrid),
            ]
        );
    }

    /**
     * Provides filters functionality.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function searchAction(Request $request)
    {
        /** @var ResponseBuilder $responseBuilder */
        $responseBuilder = $this->get('prestashop.bundle.grid.response_builder');

        return $responseBuilder->buildSearchResponse(
            $this->get('eni.blog.grid.definition.factory.categories'),
            $request,
            BlogCategoryGridDefinitionFactory::GRID_ID,
            'eniblog_category_index'
        );
    }

    /**
     * Create category
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createAction(Request $request)
    {
        $blogCategoryFormBuilder = $this->get('eni.blog.form.identifiable_object.builder.category_form_builder');
        $blogCategoryForm = $blogCategoryFormBuilder->getForm();
        $blogCategoryForm->handleRequest($request);

        $blogCategoryFormHandler = $this->get('eni.blog.form.identifiable_object.handler.category_form_handler');
        $result = $blogCategoryFormHandler->handle($blogCategoryForm);

        if (null !== $result->getIdentifiableObjectId()) {
            $this->addFlash(
                'success',
                $this->trans('Successful creation.', 'Admin.Notifications.Success')
            );

            return $this->redirectToRoute('eniblog_category_index');
        }

        return $this->render('@Modules/eniblog/views/templates/admin/create.html.twig', [
            'blogCategoryForm' => $blogCategoryForm->createView(),
        ]);
    }

    /**
     * Edit category
     *
     * @param Request $request
     * @param int $blogCategoryId
     *
     * @return Response
     */
    public function editAction(Request $request, $blogCategoryId)
    {
        $blogCategoryFormBuilder = $this->get('eni.blog.form.identifiable_object.builder.category_form_builder');
        $blogCategoryForm = $blogCategoryFormBuilder->getFormFor((int) $blogCategoryId);
        $blogCategoryForm->handleRequest($request);

        $blogCategoryFormHandler = $this->get('eni.blog.form.identifiable_object.handler.category_form_handler');
        $result = $blogCategoryFormHandler->handleFor((int) $blogCategoryId, $blogCategoryForm);

        if ($result->isSubmitted() && $result->isValid()) {
            $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));

            return $this->redirectToRoute('eniblog_category_index');
        }

        return $this->render('@Modules/eniblog/views/templates/admin/edit.html.twig', [
            'blogCategoryForm' => $blogCategoryForm->createView(),
        ]);
    }

    /**
     * Delete category
     *
     * @param int $categoryId
     *
     * @return Response
     */
    public function deleteAction($blogCategoryId)
    {
        $repository = $this->get('eni.blog.repository.category_repository');
        try {
            $category = $repository->findOneById($blogCategoryId);
        } catch (EntityNotFoundException $e) {
            $category = null;
        }

        if (null !== $category) {
            /** @var EntityManagerInterface $em */
            $em = $this->get('doctrine.orm.entity_manager');
            $em->remove($category);
            $em->flush();

            $this->addFlash(
                'success',
                $this->trans('Successful deletion.', 'Admin.Notifications.Success')
            );
        } else {
            $this->addFlash(
                'error',
                $this->trans(
                    'Cannot find category %category%',
                    'Modules.Eniblog.Admin',
                    ['%category%' => $blogCategoryId]
                )
            );
        }

        return $this->redirectToRoute('eniblog_category_index');
    }

    /**
     * Delete bulk categories
     *
     * @param Request $request
     *
     * @return Response
     */
    public function deleteBulkAction(Request $request)
    {
        $categoryIds = $request->request->get('category_bulk');
        $repository = $this->get('eni.blog.repository.category_repository');
        try {
            $categories = $repository->findById($categoryIds);
        } catch (EntityNotFoundException $e) {
            $categories = null;
        }
        if (!empty($categories)) {
            /** @var EntityManagerInterface $em */
            $em = $this->get('doctrine.orm.entity_manager');
            foreach ($categories as $category) {
                $em->remove($category);
            }
            $em->flush();

            $this->addFlash(
                'success',
                $this->trans('The selection has been successfully deleted.', 'Admin.Notifications.Success')
            );
        }

        return $this->redirectToRoute('eniblog_category_index');
    }

    /**
     * Enable categories in bulk action.
     *
     * @AdminSecurity(
     *     "is_granted('update', request.get('_legacy_controller'))",
     *     redirectRoute="eniblog_category_index",
     *     message="You do not have permission to edit this."
     * )
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function enableBulkAction(Request $request)
    {
        $categoriesIds = array_map(function ($categoryId) {
            return (int) $categoryId;
        }, $request->request->get('blog_category_bulk', []));
        dump($categoriesIds);

        try {
            $command = new BulkEnableCustomerCommand($customerIds);

            $this->getCommandBus()->handle($command);

            $this->addFlash('success', $this->trans('Successful update', 'Admin.Notifications.Success'));
        } catch (CustomerException $e) {
            $this->addFlash('error', $this->getErrorMessageForException($e, $this->getErrorMessages($e)));
        }

        return $this->redirectToRoute('eniblog_category_index');
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
