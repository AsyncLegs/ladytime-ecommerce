<?php

namespace AppBundle\Controller\API;

use AppBundle\Controller\API\Base\BaseAPIController;
use AppBundle\Entity\Product;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class ProductController extends BaseAPIController
{
    /**
     * @Rest\Get("/api/v1/product/{id}")
     */
    public function getByIdAction($id)
    {
        $product = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->find($id);
        if ($product === null) {
            return new View("There is no product exist", Response::HTTP_NOT_FOUND);
        }

        return $product;
    }

    /**
     * @Rest\Post("/api/v1/cart/{id}")
     * @ParamConverter("product", class="AppBundle:Product")
     * @param Product $product
     * @return Product
     */
    public function addToCart(Product $product)
    {
        $cart = $this->get('session')->get('cart') ?? [];
        if (empty($cart['products'][$product->getSku()])) {
            $cart['products'][$product->getSku()] = ['qty' => 0, 'product' => []];

        }

        $cart['products'][$product->getSku()]['qty'] = (int) ++$cart['products'][$product->getSku()]['qty'] ?? 0;
        $cart['products'][$product->getSku()]['product']=  $product;
        $cart['qty'] = array_reduce($cart['products'], function ($carry, $item) {
            $carry+=$item['qty'];

            return $carry;
        });
        $cart['total'] = array_reduce($cart['products'], function ($carry, $item) {
            $itemPrice = 0;
            if ($item['product'] instanceof Product) {
                $itemPrice = $item['qty'] * $item['product']->getFirstPrice()->getAmount();
            }
            $carry+=$itemPrice;

            return $carry;
        });
        //die;
        $this->get('session')->set('cart', $cart);

        return $cart;
    }
}