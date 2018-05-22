<?php

namespace AppBundle\Controller\Base;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;

class BaseController extends Controller
{
    protected function getErrors(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->all() as $key => $child) {
            if (!$child->isValid()) {
                foreach ($child->getErrors() as $error) {
                    $errors[$key] = $error->getMessage();
                }
            }
        }

        return $errors;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(name="topNavigation", path="/navigation")
     */
    public function topNavigation()
    {
        $categoryRepo = $this->getDoctrine()->getRepository('AppBundle:Category');

        $categories =
            $this->getDoctrine()
                ->getManager()
                ->createQueryBuilder()
                ->select('node')
                ->from('AppBundle:Category', 'node')
                ->orderBy('node.root, node.lft', 'ASC')
                ->where('node.isActive = 1')
                ->getQuery()
                ->getArrayResult();
        //dump($categories);die();
        $categories = $categoryRepo->buildTree($categories);


        return $this->render('@App/navigation/top.menu.html.twig', \compact('categories'));
    }

}