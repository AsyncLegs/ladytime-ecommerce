<?php

namespace AppBundle\Controller;

use AppBundle\Controller\Base\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AccountController extends BaseController
{

    /**
     * @Route(name="account", path="/account")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {

        return $this->render('@App/auth/account/account.html.twig');
    }
}
