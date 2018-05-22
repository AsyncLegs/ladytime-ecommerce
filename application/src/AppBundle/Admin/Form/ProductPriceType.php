<?php

namespace AppBundle\Admin\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class ProductPriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add(
                'price',
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