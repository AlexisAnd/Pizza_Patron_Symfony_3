<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pizzas
 *
 * @ORM\Table(name="pizzas")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PizzasRepository")
 */
class Pizzas
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="pricejunior", type="float")
     */
    private $priceJunior;

    /**
     * @var float
     *
     * @ORM\Column(name="pricemedium", type="float")
     */
    private $priceMedium;

    /**
     * @var float
     *
     * @ORM\Column(name="pricesenor", type="float")
     */
    private $priceSenor;


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
     * @return Pizzas
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
     * Set description
     *
     * @param string $description
     *
     * @return Pizzas
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Set priceJunior
     *
     * @param float $priceJunior
     *
     * @return Pizzas
     */
    public function setPriceJunior($priceJunior)
    {
        $this->priceJunior = $priceJunior;

        return $this;
    }

    /**
     * Get priceJunior
     *
     * @return float
     */
    public function getPriceJunior()
    {
        return $this->priceJunior;
    }

    /**
     * Set priceMedium
     *
     * @param float $priceMedium
     *
     * @return Pizzas
     */
    public function setPriceMedium($priceMedium)
    {
        $this->priceMedium = $priceMedium;

        return $this;
    }

    /**
     * Get priceMedium
     *
     * @return float
     */
    public function getPriceMedium()
    {
        return $this->priceMedium;
    }

    /**
     * Set priceSenor
     *
     * @param float $priceSenor
     *
     * @return Pizzas
     */
    public function setPriceSenor($priceSenor)
    {
        $this->priceSenor = $priceSenor;

        return $this;
    }

    /**
     * Get priceSenor
     *
     * @return float
     */
    public function getPriceSenor()
    {
        return $this->priceSenor;
    }
}
