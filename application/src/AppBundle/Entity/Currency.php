<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Currency
 *
 * @ORM\Table(name="currency")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CurrencyRepository")
 */
class Currency
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
     * @ORM\Column(name="name", type="string", length=3, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="base_currency_name", type="string", length=3, nullable=true)
     */
    private $baseCurrencyName;


    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float")
     */
    private $value;

    /**
     * @var \DateTime $createdAt
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdAt;

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
     * @return Currency
     */
    public function setName($name): ?Currency
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName():?string
    {

        return $this->name;
    }

    /**
     * Set baseCurrencyName
     *
     * @param string $baseCurrencyName
     *
     * @return Currency
     */
    public function setBaseCurrencyName($baseCurrencyName): ?Currency
    {
        $this->baseCurrencyName = $baseCurrencyName;

        return $this;
    }

    /**
     * Get baseCurrencyName
     *
     * @return string
     */
    public function getBaseCurrencyName()
    {
        return $this->baseCurrencyName;
    }

    /**
     * Set value
     *
     * @param float $value
     *
     * @return Currency
     */
    public function setValue(float $value): ?Currency
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue(): ?float
    {
        return $this->value;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): ? \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Currency|null
     */
    public function setCreatedAt(\DateTime $createdAt): ?Currency
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name ?? '';
    }


}

