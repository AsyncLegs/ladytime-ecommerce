<?php

namespace AppBundle\Admin;

use libphonenumber\PhoneNumberFormat;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'users';

    protected $formOptions = [
        'validation_groups' => ['update'],
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Account data')
            ->with('Details')
            ->add('email', EmailType::class, ['label_format' => '%name%'])
            ->add('username', TextType::class, ['label_format' => '%name%'])
            ->add(
                'phone',
                PhoneNumberType::class,
                [
                    'label_format' => '%name%',
                    'format' => PhoneNumberFormat::NATIONAL,
                ]
            )
            ->add(
                'plainPassword',
                PasswordType::class,
                [
                    'label' => 'password',
                    'label_format' => '%name%',
                    'required' => true,
                ]
            )
            ->end()
            ->end()
            ->tab('Access Info')
            ->with('Details')
            ->add(
                'userRoles',
                EntityType::class,
                [
                    'class' => 'AppBundle:Role',
                    'choice_label' => 'name',
                    'multiple' => true,
                ]
            )
            ->end()
            ->end()
            ->tab('Profile')
            ->with('Profile data')
            ->add('profile.first_name', TextType::class)
            ->add('profile.last_name', TextType::class)
            //->add('profile.birthday', 'date')
            ->end()
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

        $datagridMapper->add('username');
        $datagridMapper->add('createdAt');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add(
            'id',
            null,
            [
                'editable' => false,
            ]
        );
        $listMapper->addIdentifier('profile.first_name');
        $listMapper->addIdentifier('profile.last_name');
        $listMapper->addIdentifier('username');
        $listMapper->addIdentifier('email');
        $listMapper->addIdentifier('createdAt');
    }
}
