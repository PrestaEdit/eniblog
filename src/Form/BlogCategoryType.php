<?php

namespace Eni\Blog\Form;

use PrestaShop\PrestaShop\Core\ConstraintValidator\Constraints\DefaultLanguage;
use PrestaShopBundle\Form\Admin\Type\FormattedTextareaType;
use PrestaShopBundle\Form\Admin\Type\SwitchType;
use PrestaShopBundle\Form\Admin\Type\TranslatableType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;

class BlogCategoryType extends TranslatorAwareType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TranslatableType::class, [
                'type' => TextType::class,
                'label' => 'Title',
                'help' => 'Category title (e.g. News).',
                'translation_domain' => 'Modules.Eniblog.Admin',
                'constraints' => [
                    new DefaultLanguage([
                        'message' => $this->trans(
                            'The field %field_name% is required at least in your default language.',
                            'Admin.Notifications.Error',
                            [
                                '%field_name%' => sprintf(
                                    '"%s"',
                                    $this->trans('Content', 'Modules.Eniblog.Admin')
                                ),
                            ]
                        ),
                    ]),
                ],
                'options' => [
                    'constraints' => [
                        new Regex([
                            'pattern' => '/^[^<>;=#{}]*$/u',
                            'message' => $this->trans('%s is invalid.', 'Admin.Notifications.Error'),
                        ]),
                    ],
                ],
            ])
            ->add(
                'description',
                TranslatableType::class, [
                    'type' => FormattedTextareaType::class,
                    'locales' => $this->locales,
                    'label' => 'Description',
                    'translation_domain' => 'Modules.Eniblog.Admin',
                ]
            )
            ->add('active', SwitchType::class, [
                'label' => 'Enabled',
                'translation_domain' => 'Modules.Eniblog.Admin',
                'required' => false,
            ])
        ;
    }
}
