<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
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
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", unique=true)
     */
    private $slug;
    /**
     * @var int
     *
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @var int
     *
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @var int
     *
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @var Category
     *
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $root;

    /**
     * @var Category
     *
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @var Category
     *
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;



    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Banner")
     * @ORM\JoinTable(name="categories_banners", joinColumns={@ORM\JoinColumn(name="banner_id",
     * referencedColumnName="id")},inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")})
     * @var ArrayCollection $banners
     */

    private $banners;

    /**
     * @var boolean $isActive
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @return bool
     */
    public function isActive(): ?bool
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
     * @return ArrayCollection
     */
    public function getBanners()
    {
        return $this->banners;
    }

    /**
     * @param ArrayCollection $banners
     */
    public function setBanners(ArrayCollection $banners)
    {
        $this->banners = $banners;
    }

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->banners = new ArrayCollection();
    }

    /**
     * @return Category
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return int
     */
    public function getLeft()
    {
        return $this->lft;
    }

    /**
     * @return int
     */
    public function getRight()
    {
        return $this->rgt;
    }

    public function getLevel()
    {
        return $this->lvl;
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
     * Set title
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name):Category
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }



    public function getRoot(): Category
    {
        return $this->root;
    }

    public function setParent(Category $parent = null)
    {
        $this->parent = $parent;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function __toString()
    {
        return $this->name ?? '';
    }


}

