<?php
/**
 * Created by PhpStorm.
 * User: thawy
 * Date: 9/11/17
 * Time: 12:41 AM
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CurrencyAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', TextType::class, ['label' => 'Currency Name'])
            ->add('value', TextType::class, ['label' => 'Value'])
        ;
    }

// Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

    }

// Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, [
                'editable' => false
            ])
            ->add('baseCurrencyName', null, [
                'editable' => false
            ])
            ->add('value', null, [
                'editable' => false
            ])
            ->add('createdAt', null, [
                'editable' => false
            ]);
    }
}