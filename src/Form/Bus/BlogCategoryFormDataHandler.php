<?php

namespace Eni\Blog\Form;

use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataHandler\FormDataHandlerInterface;

class BlogCategoryFormDataHandler implements FormDataHandlerInterface
{
    /**
     * @var CommandBusInterface
     */
    private $commandBus;

    /**
     * @param CommandBusInterface $commandBus
     */
    public function __construct(
        CommandBusInterface $commandBus
    ) {
        $this->commandBus = $commandBus;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $addBlogCategoryCommand = new AddBlogCategoryCommand(
            $data['active'],
            $data['title'],
            $data['description']
        );

        $blogCategoryId = $this->commandBus->handle($addBlogCategoryCommand);

        return $blogCategoryId->getValue();
    }

    /**
     * {@inheritdoc}
     *
     * @throws ContactException
     */
    public function update($id, array $data)
    {
        $editBlogCategoryCommand = (new EditBlogCategoryCommand((int) $id))
            ->setActive($data['active'])
            ->setTitle($data['title'])
            ->setDescription($data['description']);

        $this->commandBus->handle($editBlogCategoryCommand);
    }
}
