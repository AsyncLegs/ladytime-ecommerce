<?php

namespace AppBundle\DTO;

class Private24CurrencyDTO extends CurrencyDTO
{

    protected $name;

    protected $baseCurrencyName;

    protected $value;

    /**
     * Private24CurrencyDTO constructor.
     * @param $name
     * @param $baseCurrencyName
     * @param $value
     */
    public function __construct($name, $baseCurrencyName, $value)
    {
        $this->name = $name;
        $this->baseCurrencyName = $baseCurrencyName;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getBaseCurrencyName()
    {
        return $this->baseCurrencyName;
    }

    /**
     * @param mixed $baseCurrencyName
     */
    public function setBaseCurrencyName($baseCurrencyName)
    {
        $this->baseCurrencyName = $baseCurrencyName;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

}