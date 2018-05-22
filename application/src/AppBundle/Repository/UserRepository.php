<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserRepository extends EntityRepository implements UserProviderInterface
{
    public function loadUserByUsername($username = '')
    {
        $query = $this->createQueryBuilder('u')
            ->where('u.username = :username')
            ->setParameter('username', $username)
            ->getQuery();

        return $query->setMaxResults(1)->getOneOrNullResult();
    }

    public function findBySocialAccount($id, $service)
    {
        $query = $this->createQueryBuilder('u')
            ->where("u.{$service}Id = :{$service}")
            ->setParameter($service, $id)
            ->getQuery();
        $user = $query->setMaxResults(1)->getOneOrNullResult();
        if(empty($user)) {

            throw  new EntityNotFoundException();
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        return $this->loadUserByUsername($user->getUsername());
    }
    public function supportsClass($class)
    {
        return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());
    }
}