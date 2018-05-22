<?php

namespace AppBundle\Service\Notification;

use Symfony\Component\Templating\EngineInterface;

class EmailNotificationService
{

    /**
     * @var
     */
    protected $mailer;
    protected $view;

    /**
     * EmailNotificationService constructor.
     * @param \Swift_Mailer $mailer
     * @param EngineInterface $view
     */
    public function __construct(\Swift_Mailer $mailer, EngineInterface $view)
    {
        $this->mailer = $mailer;
        $this->view = $view;
    }


    public function resetPassword($resetToken)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')
            ->setFrom('info@ladytime.com.ua')
            ->setTo('ruslan@terekhov.tk')
            ->setBody(
                $this->view->render(
                    '@App/emails/password.reset.html.twig',
                    ['token' => $resetToken]
                )
            );

        return $this->sendMessage($message);

    }

    protected function sendMessage(\Swift_Message $message)
    {
        dump($message);
        return $this->mailer->send($message);
    }

}