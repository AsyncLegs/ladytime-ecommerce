<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product_pricetype")
 */
class ProductPriceType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product", inversedBy="prices", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PriceType", inversedBy="productPriceType", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
    */
    private $priceType;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @var float $previousAmount
     * @ORM\Column(type="float")
     */
    private $previousAmount;

    /**
     * @return float
     */
    public function getPreviousAmount(): ?float
    {
        return $this->previousAmount;
    }

    /**
     * @param float $previousAmount
     */
    public function setPreviousAmount(float $previousAmount)
    {
        $this->previousAmount = $previousAmount;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getPriceType()
    {
        return $this->priceType;
    }

    /**
     * @param mixed $priceType
     */
    public function setPriceType($priceType)
    {
        $this->priceType = $priceType;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }



}