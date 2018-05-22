<?php

namespace AppBundle\Controller;


use AppBundle\Controller\Base\BaseController;
use AppBundle\Entity\Product;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends BaseController
{

    /**
     * @Route(name="all_products", path="/products")
     */
    public function listAction()
    {

    }

    /**
     * @param $slug
     * @Route(name="show_products_by_category", path="/products/{slug}")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showByCategoryAction($slug)
    {
        $categoryRepo = $this->getDoctrine()->getRepository('AppBundle:Category');
        $category = $categoryRepo->findOneBy(['slug' => $slug, 'isActive' => 1]);

        $products = $this->getDoctrine()->getRepository('AppBundle:Product')
            ->findByCategory($category);
        $productsCount = count($products);

        $breadcrumbs = $categoryRepo->getPath($category);


        return $this->render('@App/store/category.html.twig', \compact('products', 'productsCount','breadcrumbs', 'category'));
    }

    /**
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(name="show_product", path="/product/{slug}")
     */
    public function showProductBySlug($slug)
    {
        $categoryRepo = $this->getDoctrine()->getRepository('AppBundle:Category');

        $product = $this->getDoctrine()->getRepository('AppBundle:Product')
            ->findBy(['slug' => $slug]);
        if( !$product instanceof Product){
            throw new NotFoundHttpException("Product with slug: {$slug} not found");
        }

        $breadcrumbs = $categoryRepo->getPath($product->getCategory());


        return $this->render('@App/store/product.html.twig', \compact('product', 'breadcrumbs', 'category'));
    }

    /**
     * @Route(name="cart", path="/cart")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cart()
    {
        $productsInCart = $this->get('session')->get('cart') ?? [];

        return $this->render('@App/store/cart.html.twig', compact('productsInCart'));
    }
}