<?php

namespace AppBundle\Doctrine;

use AppBundle\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;


class DefaultRolesSettingListener implements EventSubscriber
{


    public function getSubscribedEvents()
    {

        return ['prePersist'];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entityManager = $args->getEntityManager();

        $entity = $args->getEntity();
        if (!$entity instanceof User) {
            return;
        }

        $role = $entityManager->getRepository('AppBundle:Role')->findOneBy(['role' => 'ROLE_USER']);

        $entity->addRole($role);

    }

}