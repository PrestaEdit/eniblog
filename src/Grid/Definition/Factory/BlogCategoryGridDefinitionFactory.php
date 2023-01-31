<?php
namespace Eni\Blog\Grid\Definition\Factory;

use PrestaShop\PrestaShop\Core\Grid\Action\Bulk\BulkActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Bulk\Type\SubmitBulkAction;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\RowActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\LinkRowAction;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\SubmitRowAction;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\BulkActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ToggleColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractGridDefinitionFactory;

final class BlogCategoryGridDefinitionFactory extends AbstractGridDefinitionFactory
{
    const GRID_ID = 'blog_category';

    protected function getId()
    {
        return self::GRID_ID;
    }

    protected function getName()
    {
        return $this->trans('Categories', [], 'Modules.Eniblog.Admin');
    }

    protected function getColumns()
    {
        return (new ColumnCollection())
            ->add(
                (new BulkActionColumn('bulk'))
                    ->setOptions([
                        'bulk_field' => 'id_blog_category',
                    ])
            )
            ->add((new DataColumn('id_blog_category'))
                ->setName($this->trans('ID', [], 'Admin.Global'))
                ->setOptions([
                    'field' => 'id_blog_category',
                ])
            )
            ->add((new DataColumn('title'))
                ->setName($this->trans('Title', [], 'Modules.Eniblog.Admin'))
                ->setOptions([
                    'field' => 'title',
                ])
            )
            ->add((new DataColumn('description'))
                ->setName($this->trans('Description', [], 'Modules.Eniblog.Admin'))
                ->setOptions([
                    'field' => 'description',
                ])
            )
            ->add(
                (new ToggleColumn('active'))
                    ->setName($this->trans('Enabled', [], 'Admin.Global'))
                    ->setOptions([
                        'field' => 'active',
                        'primary_field' => 'id_blog_category',
                        'route' => 'eniblog_category_toggle_status',
                        'route_param_name' => 'blogCategoryId',
                    ])
            )
            ->add(
                (new ActionColumn('actions'))
                ->setName($this->trans('Actions', [], 'Admin.Global'))
                ->setOptions([
                    'actions' => (new RowActionCollection())
                    ->add(
                        (new LinkRowAction('edit'))
                        ->setName($this->trans('Edit', [], 'Admin.Actions'))
                        ->setIcon('edit')
                        ->setOptions([
                            'route' => 'eniblog_category_edit',
                            'route_param_name' => 'blogCategoryId',
                            'route_param_field' => 'id_blog_category',
                            'clickable_row' => true,
                        ])
                    )
                    ->add(
                        (new SubmitRowAction('delete'))
                        ->setName($this->trans('Delete', [], 'Admin.Actions'))
                        ->setIcon('delete')
                        ->setOptions([
                            'route' => 'eniblog_category_delete',
                            'route_param_name' => 'blogCategoryId',
                            'route_param_field' => 'id_blog_category',
                            'confirm_message' => $this->trans(
                                'Delete selected item?',
                                [],
                                'Admin.Notifications.Warning'
                            ),
                        ])
                    )
                ])
            )
        ;
    }

    protected function getBulkActions()
    {
        return (new BulkActionCollection())
            ->add(
                (new SubmitBulkAction('enable_selection'))
                ->setName($this->trans('Enable selection', [], 'Admin.Actions'))
                ->setOptions([
                    'submit_route' => 'eniblog_category_enable_bulk',
                ])
            )
        ;
    }
}