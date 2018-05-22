<?php

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BannerAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'banners';

    /*
     *
     */
    private $uploadableManager;

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', TextType::class)
            ->add('text', TextType::class)
            ->add('color', ColorType::class)
            ->add('description', TextType::class,['required' => false])
            ->add('url', TextType::class, [
                'required' => false
            ])
            ->add('image', FileType::class,
                [
                    'required' => false,
                    'data_class' => null,
                    'mapped' => true,
                ]
            );
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
        $datagridMapper->add('text');
        $datagridMapper->add('url');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name');
        $listMapper->addIdentifier('text');
        $listMapper->addIdentifier('description');
        $listMapper->addIdentifier('url');
    }

    public function prePersist($object)
    {
        $this->uploadableManager->markEntityToUpload($object, $object->getImage());
    }

    public function preUpdate($object)
    {
        if ($object->getImage() instanceof UploadedFile) {
            $this->uploadableManager->markEntityToUpload($object, $object->getImage());
        }
    }

    public function setUploadableManager($uploadableManager)
    {
        $this->uploadableManager = $uploadableManager;
    }

}
