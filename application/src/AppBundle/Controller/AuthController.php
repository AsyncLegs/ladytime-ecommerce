<?php

namespace AppBundle\Controller;

use AppBundle\Controller\Base\BaseController;
use AppBundle\Entity\ResetPasswordToken;
use AppBundle\Entity\User;
use AppBundle\Form\User\RegisterForm;
use AppBundle\Service\Notification\EmailNotificationService;
use AppBundle\Service\Security\ResetPassword;
use Doctrine\ORM\UnitOfWork;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class AuthController extends BaseController
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(name="register", path="/connect")
     */
    public function registerAction(Request $request)
    {
        $response = [
            'message' => null,
            'logged' => false,
        ];
        $user = new User();

        if ($request->getSession()->has('socialAccount')) {
            $socialAccount = $request->getSession()->get('socialAccount');
            if (!empty($socialAccount)) {
                $user->setEmail($socialAccount->email ?: null);
                $user->setSocialNetwork($socialAccount);
                $user->getProfile()->attachSocialAccount($socialAccount);
            }
        }
        $form = $this->createForm(RegisterForm::class, $user, [
            'validation_groups' => 'register'
        ]);

        if ($request->isXmlHttpRequest()) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $isPersisted = UnitOfWork::STATE_MANAGED === $em->getUnitOfWork()->getEntityState($user);

                if ($isPersisted) {
                    $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                    $this->get('security.token_storage')->setToken($token);
                    $this->get('session')->set('_security_main', serialize($token));
                    $this->get('session')->remove('socialAccount');

                    $response['logged'] = true;
                    $response['message'] = $this->get('translator')->trans('register_success');
                    $response['url'] = $this->redirectToRoute('account')->getTargetUrl();
                }
            } else {

                $response['errors'] = $this->getErrors($form);
            }

            return new JsonResponse($response);
        }

        return $this->render('@App/auth/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function loginAction(AuthenticationUtils $authUtils)
    {

    }

    public function passwordResetAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(User::class);
        $resetToken = $request->get('token');
        $email = $request->get('email');

        $notificationSer = $this->get(EmailNotificationService::class);

        dump($notificationSer->resetPassword($resetToken));

        if ($email) {
            $user = $repository->findOneBy([
                'email' => $request->get('email'),
            ]);

            if ($user) {
                $resetPasswordManager = $this->get(ResetPassword::class);
                $resetPasswordToken = new ResetPasswordToken();
                $resetPasswordToken->setToken($resetPasswordManager->generateToken());
                $resetPasswordToken->setUser($user);
                $em->persist($resetPasswordToken);
                $em->flush();

            }
        }

        return $this->render('@App/auth/password-reset.html.twig');
    }

}