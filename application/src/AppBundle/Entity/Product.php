<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(name="short_description", type="text")
     */
    private $shortDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="full_description", type="text")
     */
    private $fullDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="sku", type="string", length=255)
     */
    private $sku;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProductPriceType", mappedBy="product", fetch="EXTRA_LAZY", cascade={"persist"}, orphanRemoval=true)
     */
    private $prices;

    /**
     * @var boolean $isActive
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;


    /**
     * @ORM\Column(type="array", nullable=true)
     */
    protected $images;


    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     */
    protected $category;

    /**
     * @var string
     * @Gedmo\Slug(fields={"shortDescription"})
     * @ORM\Column(name="slug", type="string", unique=true)
     */
    private $slug;

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }



    /**
     * @return Category
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }


    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->prices = new ArrayCollection();
    }

    /**
     * @return Collection
     */
    public function getPrices(): ?Collection
    {
        return $this->prices;
    }

    public function getFirstPrice(): ?ProductPriceType
    {
        return $this->getPrices()->first();
    }


    /**
     * @param Collection $prices
     * @return Product
     */
    public function setPrices(Collection $prices)
    {
        $this->prices = $prices;
        foreach ($prices as $price) {

            $price->setProduct($this);
        }

        return $this;
    }

    public function addPrice(ProductPriceType $price)
    {
        $this->prices->add($price);
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive)
    {
        $this->isActive = $isActive;
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
     * @return Product
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
     * Set shortDescription
     *
     * @param string $shortDescription
     *
     * @return Product
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set fullDescription
     *
     * @param string $fullDescription
     *
     * @return Product
     */
    public function setFullDescription($fullDescription)
    {
        $this->fullDescription = $fullDescription;

        return $this;
    }

    /**
     * Get fullDescription
     *
     * @return string
     */
    public function getFullDescription()
    {
        return $this->fullDescription;
    }

    /**
     * Set sku
     *
     * @param string $sku
     *
     * @return Product
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param mixed $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }


    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getUploadRootDir()
    {

        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        return 'uploads/products';
    }

    public function getAbsolutePath()
    {
        return null === $this->images ? null : $this->getUploadRootDir().'/'.$this->images;
    }

    public function getWebPath()
    {
        return null === $this->images ? null : '/'.$this->getUploadDir().'/'.$this->images;
    }

    public function __toString()
    {
        return $this->getName() ?? '';
    }


}

