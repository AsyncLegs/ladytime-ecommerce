<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Price
 *
 * @ORM\Table(name="price_types")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PriceRepository")
 */
class PriceType
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Currency"))
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     */
    private $currency;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProductPriceType", mappedBy="priceType")
     */
    private $productPriceType;

    /**
     * @return mixed
     */
    public function getProductPriceType()
    {
        return $this->productPriceType;
    }

    /**
     * @param mixed $productPriceType
     */
    public function setProductPriceType($productPriceType)
    {
        $this->productPriceType = $productPriceType;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return PriceType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return PriceType
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }
}

