<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Orderline
 *
 * @ORM\Table(name="orderline")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderlineRepository")
 */
class Orderline
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
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="pizzaId", type="integer", nullable=true)
     */
    private $pizzaId;

    /**
     * @var int
     *
     * @ORM\Column(name="paninisId", type="integer", nullable=true)
     */
    private $paninisId;

    /**
     * @var int
     *
     * @ORM\Column(name="texmexId", type="integer", nullable=true)
     */
    private $texmexId;

    /**
     * @var int
     *
     * @ORM\Column(name="dessertsId", type="integer", nullable=true)
     */
    private $dessertsId;

    /**
     * @var int
     *
     * @ORM\Column(name="drinksId", type="integer", nullable=true)
     */
    private $drinksId;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=true )
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="orderId", type="integer", nullable=true)
     */
    private $orderId;

    /**
     * @var int
     *
     * @ORM\Column(name="userId", type="integer", nullable=true)
     */
    private $userId;


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
     * @return Orderline
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
     * Set pizzaId
     *
     * @param integer $pizzaId
     *
     * @return Orderline
     */
    public function setPizzaId($pizzaId)
    {
        $this->pizzaId = $pizzaId;

        return $this;
    }

    /**
     * Get pizzaId
     *
     * @return integer
     */
    public function getPizzaId()
    {
        return $this->pizzaId;
    }

    /**
     * Set paninisId
     *
     * @param integer $paninisId
     *
     * @return Orderline
     */
    public function setPaninisId($paninisId)
    {
        $this->paninisId = $paninisId;

        return $this;
    }

    /**
     * Get paninisId
     *
     * @return int
     */
    public function getPaninisId()
    {
        return $this->paninisId;
    }

    /**
     * Set texmexId
     *
     * @param integer $texmexId
     *
     * @return Orderline
     */
    public function setTexmexId($texmexId)
    {
        $this->texmexId = $texmexId;

        return $this;
    }

    /**
     * Get texmexId
     *
     * @return int
     */
    public function getTexmexId()
    {
        return $this->texmexId;
    }

    /**
     * Set dessertsId
     *
     * @param integer $dessertsId
     *
     * @return Orderline
     */
    public function setDessertsId($dessertsId)
    {
        $this->dessertsId = $dessertsId;

        return $this;
    }

    /**
     * Get dessertsId
     *
     * @return int
     */
    public function getDessertsId()
    {
        return $this->dessertsId;
    }

    /**
     * Set drinksId
     *
     * @param integer $drinksId
     *
     * @return Orderline
     */
    public function setDrinksId($drinksId)
    {
        $this->drinksId = $drinksId;

        return $this;
    }

    /**
     * Get drinksId
     *
     * @return int
     */
    public function getDrinksId()
    {
        return $this->drinksId;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Orderline
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
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

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Orderline
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set orderId
     *
     * @param integer $orderId
     *
     * @return Orderline
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get orderId
     *
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Orderline
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }


    /**
     * Set orders
     *
     * @param \AppBundle\Entity\Orders $orders
     *
     * @return Orderline
     */
    public function setOrders(\AppBundle\Entity\Orders $orders = null)
    {
        $this->orders = $orders;

        return $this;
    }

    /**
     * Get orders
     *
     * @return \AppBundle\Entity\Orders
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Add panini
     *
     * @param \AppBundle\Entity\Paninis $panini
     *
     * @return Orderline
     */
    public function addPanini(\AppBundle\Entity\Paninis $panini)
    {
        $this->paninis[] = $panini;

        return $this;
    }

    /**
     * Remove panini
     *
     * @param \AppBundle\Entity\Paninis $panini
     */
    public function removePanini(\AppBundle\Entity\Paninis $panini)
    {
        $this->paninis->removeElement($panini);
    }

    /**
     * Get paninis
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPaninis()
    {
        return $this->paninis;
    }
}
