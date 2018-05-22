<?php

namespace AppBundle\Security\Provider;

use AppBundle\Entity\User;
use AppBundle\Service\Mapper\SocialAccount\SocialAccountMapper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class OAuthUserProvider implements OAuthAwareUserProviderInterface, UserProviderInterface
{


    /**
     * @var UrlMatcherInterface
     */
    protected $router;
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var \AppBundle\Repository\UserRepository
     */
    protected $repository;
    /**
     * @var \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface
     */
    protected $encoderFactory;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * Constructor
     *
     * @param UrlMatcherInterface $router
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface $encoderFactory
     * @param SessionInterface $session
     */
    public function __construct(UrlMatcherInterface $router, EntityManagerInterface $entityManager, EncoderFactoryInterface $encoderFactory, SessionInterface $session)
    {
        $this->router = $router;
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository('AppBundle:User');
        $this->encoderFactory = $encoderFactory;
        $this->session = $session;
    }


    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {

        $userId = $response->getUsername();
        $serviceId = $response->getResourceOwner()->getName();

        try {
            $user = $this->repository->findBySocialAccount($userId, $serviceId);

        } catch (EntityNotFoundException $e) {
            $socialAccount = SocialAccountMapper::socialAccountFactory($response->getResourceOwner()->getName());

            $this->session->set('socialAccount', $socialAccount->parse($response));
            $this->session->set('redirectToRegister', $this->router->generate('register', ['_fragment' => 'auth2']));

            throw new AccountNotLinkedException($e);
        }

        return $user;
    }

    public function loadUserByUsername($username)
    {
        $user = $this->repository->loadUserByUsername($username);

        if (null === $user) {
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {

        return $this->repository->refreshUser($user);
    }

    public function supportsClass($class)
    {
        return $class === User::class;
    }
}