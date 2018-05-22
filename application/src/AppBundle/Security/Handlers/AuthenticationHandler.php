<?php

namespace AppBundle\Security\Handlers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{

    private $router;

    /**
     * @var TranslatorInterface $translator
     */
    private $translator;

    public function __construct(TranslatorInterface $translator, UrlMatcherInterface $router)
    {
        $this->router = $router;
        $this->translator = $translator;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if ($request->isXmlHttpRequest()) {

            $array = [
                'logged' => true,
                'message' => $this->translator->trans('login_success'),
                'url' => $this->router->generate('account'),
            ];

            return new JsonResponse($array);
        }

        return new RedirectResponse($this->router->generate('account'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        if ($request->isXmlHttpRequest()) {

            $array = [
                'logged' => false,
                'message' => $this->translator->trans('login_error'),

            ];
            $response = new JsonResponse($array);

            return $response;
        }

        if ($request->getSession()->has('redirectToRegister')) {
            $url = $request->getSession()->get('redirectToRegister');
            $request->getSession()->remove('redirectToRegister');

            return new RedirectResponse($url);
        }

        return new RedirectResponse($this->router->generate('home'));
    }

}