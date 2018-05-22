<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ProductPriceTypeAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add(
                'priceType',
                EntityType::class,
                [
                    'class' => 'AppBundle:PriceType',
                    'choice_label' => 'name',
                ]
            )
            ->add('amount', TextType::class, ['label' => 'Amount'])
            ->add('previousAmount', TextType::class, ['label' => 'Previous Amount']);
    }


}