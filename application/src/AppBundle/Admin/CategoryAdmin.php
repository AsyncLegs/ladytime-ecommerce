<?php

namespace AppBundle\Admin;

use RedCode\TreeBundle\Admin\AbstractTreeAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoryAdmin extends AbstractTreeAdmin
{
    protected $baseRouteName = 'category';

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->addIdentifier('slug');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        // create custom query to hide the current element by `id`

        $subjectId = $this->getRoot()->getSubject()->getId();
        $query = null;

        if ($subjectId) {
            $query = $this->modelManager
                ->getEntityManager('AppBundle\Entity\Category')
                ->createQueryBuilder('c')
                ->select('c')
                ->from('AppBundle:Category', 'c')
                ->where('c.id != '.$subjectId);
        }

        $formMapper
            ->add('name', TextType::class)
            ->add('slug', TextType::class, ['required' => false])
            ->add('isActive', CheckboxType::class)
            ->add(
                'Banners',
                EntityType::class,
                [
                    'class' => 'AppBundle:Banner',
                    'choice_label' => 'name',
                    'multiple' => true,
                ]
            )
            ->add(
                'parent',
                ModelType::class,
                [
                    'query' => $query,
                    'required' => false, // remove this row after the root element is created
                    'btn_add' => false,
                    'property' => 'name',
                ]
            );
    }
}
