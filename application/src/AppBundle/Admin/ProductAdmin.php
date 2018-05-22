<?php

namespace AppBundle\Admin;

use AppBundle\Admin\Form\ProductPriceType;
use AppBundle\Entity\Price;
use Comur\ImageBundle\Form\Type\CroppableGalleryType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductAdmin extends AbstractAdmin
{
    protected $context = 'default';

    public function prePersist($object)
    {
        $object->setPrices($object->getPrices());
        //\dump($object);die();
    }

    public function preUpdate($object)
    {
        $object->setPrices($object->getPrices());
        // \dump($object);die();

    }


    protected function configureFormFields(FormMapper $formMapper)
    {
        $product = $this->getRoot()->getSubject();

        $formMapper
            ->tab('Product data')
            ->with('Details')
            ->add('name', TextType::class, ['label_format' => '%name%'])
            ->add('short_description', TextareaType::class, ['label_format' => '%name%'])
            ->add('full_description', TextareaType::class, ['label_format' => '%name%'])
            ->add('sku', TextType::class, ['label_format' => '%name%'])
            ->add('quantity', TextType::class, ['label_format' => '%name%'])
            ->end()
            ->end()
            ->tab('Product Extra')
            ->add(
                'Category',
                EntityType::class,
                array(
                    'class' => 'AppBundle:Category',
                    'choice_label' => 'name',
                    'multiple' => false,
                )
            )
            ->add(
                'prices',
                CollectionType::class,
                [],
                [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'id',
                ]
            )
            ->end()
            ->end()
            ->tab('Product Images')
            ->add(
                'images',
                CroppableGalleryType::class,
                [
                    'uploadConfig' => [
                        'uploadUrl' => $product->getUploadRootDir(),
                        'webDir' => $product->getUploadDir(),
                        'fileExt' => '*.jpg;*.gif;*.png;*.jpeg',
                        'showLibrary' => true,
                    ],
                    'cropConfig' => [
                        'forceResize' => false,
                        'aspectRatio' => false,
                        'thumbs' => [
                            [
                                'maxWidth' => 1024,
                                'maxHeight' => 768,
                            ],
                        ],
                    ],
                ]
            )
            ->end()
            ->end();
    }

// Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

    }

// Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->addIdentifier('short_description')
            ->addIdentifier('full_description')
            ->addIdentifier('sku')
            ->addIdentifier('quantity');
    }
}